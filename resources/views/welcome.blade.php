public function up(): void
{
    Schema::table('feedback', function (Blueprint $table) {
        $table->enum('list_type', ['main', 'jay', 'others'])
              ->default('main')
              ->after('type');
    });
}

public function down(): void
{
    Schema::table('feedback', function (Blueprint $table) {
        $table->dropColumn('list_type');
    });
}

{{-- ============================================================== --}}
public function complaints(Request $request)
{
    $listType = $request->get('list_type', 'main');

    $query = Feedback::where('type', 'complaint')
        ->where('list_type', $listType);

    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('created_at', [
            $request->from_date . ' 00:00:00',
            $request->to_date . ' 23:59:59'
        ]);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('department_id')) {
        $query->whereHas('user.departments', fn ($q) =>
            $q->where('id', $request->department_id)
        );
    }

    if ($request->filled('building_id')) {
        $query->whereHas('rooms.buildings', fn ($q) =>
            $q->where('id', $request->building_id)
        );
    }

    $complaints = $query->with([
        'rooms.floors',
        'rooms.buildings',
        'user.departments'
    ])->latest()->get();

    $departments = Department::orderBy('name')->get();
    $buildings   = Building::orderBy('name')->get();

    return view('admin.complaint.index', compact(
        'complaints',
        'departments',
        'buildings',
        'listType'
    ));
}

{{-- ========================================================================== --}}
<a href="{{ route('complaints',['list_type'=>'main']) }}">All Complaints</a>
<a href="{{ route('complaints',['list_type'=>'jay']) }}">Jay Complaints</a>
<a href="{{ route('complaints',['list_type'=>'others']) }}">Other Complaints</a>

<th>
    <input type="checkbox" id="selectAll">
</th>
<th>Unique Id</th>

<td>
    <input type="checkbox"
           class="complaint-checkbox"
           name="complaint_ids[]"
           value="{{ $complaint->id }}">
</td>
<td>{{ $complaint->unique_id }}</td>

{{-- ====================================================================== --}}
<form method="POST" action="{{ route('complaints.move') }}" id="moveForm">
    @csrf

    <input type="hidden" name="move_to" id="moveTo">

    <div id="moveActions" class="d-none">
        <button type="button" class="btn btn-info"
                onclick="moveComplaints('jay')">
            Move to Jay
        </button>

        <button type="button" class="btn btn-warning"
                onclick="moveComplaints('others')">
            Move to Others
        </button>
    </div>
</form>

{{-- ========================= --}}
<script>
const checkboxes = document.querySelectorAll('.complaint-checkbox');
const moveBox = document.getElementById('moveActions');

checkboxes.forEach(cb => {
    cb.addEventListener('change', toggleMoveBox);
});

document.getElementById('selectAll').addEventListener('change', function () {
    checkboxes.forEach(cb => cb.checked = this.checked);
    toggleMoveBox();
});

function toggleMoveBox() {
    let checked = document.querySelectorAll('.complaint-checkbox:checked');
    moveBox.classList.toggle('d-none', checked.length === 0);
}

function moveComplaints(type) {
    document.getElementById('moveTo').value = type;
    document.getElementById('moveForm').submit();
}
</script>
{{-- ===================================================================================== --}}
public function moveComplaints(Request $request)
{
    $request->validate([
        'complaint_ids' => 'required|array',
        'move_to' => 'required|in:jay,others'
    ]);

    Feedback::whereIn('id', $request->complaint_ids)
        ->update(['list_type' => $request->move_to]);

    return back()->with('success', 'Complaints moved successfully');
}
{{-- ======================================== --}}
Route::post('/admin/complaints/move',
    [AdminController::class, 'moveComplaints']
)->name('complaints.move');

