@extends('layouts.backend.app')

@section('meta')
    <title>Register | Northern Railway</title>
@endsection

@section('style')
    <style>
        body {
            background: linear-gradient(135deg, #0B1E47, #1AB79D);
            font-family: 'Poppins', sans-serif;
        }

        .card-register {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            color: #333333;
            max-width: 800px;
            margin: 0 auto;
        }

        .card-register h2 {
            font-size: 30px;
            font-weight: 700;
            color: #1AB79D;
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            color: #495057;
            border-radius: 8px;
            padding: 10px 15px;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #1AB79D;
            box-shadow: 0 0 0 0.2rem rgba(26, 183, 157, 0.25);
            background-color: #fff;
        }

        .btn-primary {
            background-color: #1AB79D;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 30px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #17a98d;
        }

        .input-group .btn {
            background-color: #e9ecef;
            border: none;
            color: #495057;
        }

        .alert {
            border-radius: 8px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .form-group.col-lg-6 {
                width: 100%;
            }
        }
    </style>
@endsection



@section('content')
    <!--[ Page Content ] start -->
    <div class="page-content" style="background-color: #f2f4f8; min-height: 100vh;">
        <div class="container-fluid">

            <!-- [ breadcrumb ] start -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Register</h4>
                        <div class="page-title-right">
                            <a href="{{ url('/admin/users') }}" class="btn btn-primary waves-effect waves-light">
                                <i class="bx bx-user"></i> All Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card-register mt-4">
                        <h2 class="text-center">Create an Account</h2>

                        {{-- Alerts --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session('error') }}</div>
                        @endif

                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session('success') }}</div>
                        @endif

                        {{-- Form --}}
                        <form action="{{ route('admin.register.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="form-group col-lg-6 mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Enter Name" value="">
                                </div>

                                <div class="form-group col-lg-6 mb-3">
                                    <label for="mobile">Mobile No.</label>
                                    <input type="tel" name="mobile" id="mobile" class="form-control" maxlength="10"
                                        pattern="\d{10}" inputmode="numeric" placeholder="Enter 10-digit mobile number">
                                </div>

                                <div class="form-group col-lg-6 mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Enter Email" value="">
                                </div>

                                <div class="form-group col-lg-6 mb-3">
                                    <label for="department">Department</label>
                                    <select name="department_id" class="form-select" required>
                                        <option value="">-- Select Department --</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-6 mb-3">
                                    <label for="password">Password</label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Enter password">
                                        <button class="btn" type="button"
                                            onclick="togglePasswordVisibility('password', 'password-addon1')">
                                            <i class="mdi mdi-eye-outline" id="password-addon1"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 mb-3">
                                    <label for="confirm-password">Confirm Password</label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="confirm-password" placeholder="Confirm password">
                                        <button class="btn" type="button"
                                            onclick="togglePasswordVisibility('confirm-password', 'password-addon2')">
                                            <i class="mdi mdi-eye-outline" id="password-addon2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary px-5">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('script')
    <script>
        function togglePasswordVisibility(passwordFieldId, iconId) {
            const passwordField = document.getElementById(passwordFieldId);
            const icon = document.getElementById(iconId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.replace("mdi-eye-outline", "mdi-eye-off-outline");
            } else {
                passwordField.type = "password";
                icon.classList.replace("mdi-eye-off-outline", "mdi-eye-outline");
            }
        }
    </script>
    <script>
        document.getElementById('mobile').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
@endsection
