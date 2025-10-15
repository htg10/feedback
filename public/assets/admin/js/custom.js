
// For Product Type Field Js
$(document).ready(function () {
    $("#parentCategory").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue) {
                $("#productType").hide();
            } else {
                $("#productType").show();
            }
        });
    }).change();
});

// For dropify Js
$(document).ready(function () {
    $('.dropify').dropify();
});

// For Meta Field Js
// $(document).ready(function(){
//     $("#chkMeta").click(function () {
//         if ($(this).is(":checked")) {
//             $("#metaInputs").show();
//         } else {
//             $("#metaInputs").hide();
//         }
//     });
// });

document.getElementById('vertical-menu-btn').addEventListener('click', function () {
    const logoText = document.querySelector('.navbar-brand-box span');
    if (logoText) {
        logoText.classList.toggle('d-none');
    }
});
