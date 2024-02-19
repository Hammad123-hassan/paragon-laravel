{{-- <style>
    .fi-sidebar {
        background: #005974 !important;
    }
    .fi-sidebar-item{
        color: white !important;
    }

    .flex-1{
        color: #ffffff;
    }
   
    /* .text-primary-600{
        background: #00969B; */
        /* color:white; */
    /* } */
    .fi-sidebar-item-icon{
        color: white;
    }
    .fi-checkbox-input{
        background: white; 
    }
    .fi-tabs-item{
        background: white;
    }
   
    .fi-ta-text .grid .gap-y-1 .px-3 .py-4 {
        padding: 0px !important;
    }
  

   .hover\:bg-gray-100:hover{
      background: #00969B;
   }

   .fi-dropdown-header-label{
    color: #005974;
   }

   .fi-dropdown-list-item-label{
    color: #005974;
   }
   

   .fi-tabs{
        color: #005974;
   }

   .bg-\[\#0979CC\] {
    background: #005974 !important;
   }

   .text-\[\#0979CC\]{
    color: #005974 !important;
   }
   .hover\:bg-\[\#0979CC\]:hover{
    background: #005974 !important;
   }
 
 .textarea{
    color: #005974 !important;
 }
 .apexcharts-theme-light .apexcharts-menu-item:hover{
     color: #005974 !important;
 }

 .apexcharts-menu{
    background:  #005974 !important;
 }

 .fi-tabs-item-active {
    color: white !important;
  background: #05969b !important;
  


}

 .fi-tabs-item {
  
  color:  #005974 ;
  /* background: #ffffff !important; */
}

.filament-table-repeater-header-column{
    color: #ffffff !important;
}

.focus\:bg-gray-100:focus{
    background: #05969b !important;
}
.fi-tabs-item-icon .h-5 .w-5 .text-green-400  {
    color: green;
}

.bg-custom-600{
    background: #005974 !important;
}
.apexcharts-tooltip.apexcharts-theme-light{
    color: #05969b;
}

.apexcharts-theme-light .apexcharts-menu-item:hover{
    background: #05969b;
}

.bg-gray-100{
    background: #05969b;
}

</style> --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<link rel="stylesheet" href="{{ url('/') }}/listree.min.css">
<script src="{{ url('/') }}/listree.umd.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .fi-sidebar-header {

        height: auto;

    }

    .h-6.w-11 {
        background: #00969b;
    }

    .bg-gray-200 {
        background: #e5e7eb !important;
    }

    .bg-custom-600 {
        background: red;
    }

    .fi-btn-color-primary {
        background: #005974;
    }

    .fi-sidebar-open {
        background: #00597408;
        padding-top: 0px !important;
    }

    .fi-tabs-item-active {
        background: #005974;
    }

    .fi-tabs-item-active span {
        color: #005974 !important;
    }

    .fi-tabs-item-active svg {
        color: #005974 !important;
    }

    .fi-tabs-item span {
        color: #fff;
    }

    .fi-tabs-item svg {
        color: #fff;
    }

    /* .fi-tabs-item-label {
    color:#ffffff
} */
    .fi-ta-text {
        padding: 2px;


    }

    .fi-ta-cell div {
        padding: 2px;
        font-size: 11px;
        font-weight: 500;


    }
    .fi-sidebar-header{
        background-color: #f1f5f7;
    }

    .fi-badge {
        background: none;
    }
    .fi-btn:hover{
        background-color: #005974;
    }

    /* .ring-custom-600\/10{
    --tw-ring-color: rgb(235, 230, 230);
} */

    /* Custom Addition */
    .select2-container--default .select2-selection--single {
        border: none !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 12px;
        color: #040404 !important;
        padding-top: 0.625rem !important;
        padding-bottom: 0.625rem !important;
        border: 1px solid;
        line-height: 1rem !important;
        border: 1px solid #DBDADE !important;
        border-radius: 0.25rem !important;

    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {

        top: 6px !important;
        right: 1px !important;

    }

    /* .custom-select{
    margin-bottom: 10px;
} */
.choices__inner{
       
        padding-top: 0.4rem !important;
        padding-bottom: 0.4rem !important;
        border: 1px solid;
        line-height: 1rem !important;
        border: 1px solid #DBDADE !important;
        border-radius: 0.25rem !important;
        padding: 0.5rem;
        background-image: url("/dropdown.png") !important;
        background-size: 7px !important; 
        background-position:right .5rem center;
        background-repeat: no-repeat
}
.choices__inner input::placeholder{
    font-size: 12px;
        color: #040404 !important;
}
    select {
        font-size: 12px;
        color: #040404 !important;
        padding-top: 0.625rem !important;
        padding-bottom: 0.625rem !important;
        border: 1px solid;
        line-height: 1rem !important;
        border: 1px solid #DBDADE !important;
        border-radius: 0.25rem !important;
        padding: 0.5rem;
        background-image: url("/dropdown.png") !important;
        background-size: 7px !important;
    }

    .select2-search__field {
        font-size: 12px;
        color: #040404 !important;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-results__option[aria-selected] {
        font-size: 12px;
        color: #040404 !important;
    }

    .select2-results__option[aria-selected] span {
        font-size: 12px;
        color: #040404 !important;
    }

    /* button{
        background: #00969B !important;
        color: #ffffff !important;
    } */

    /* case study css addition */
    .fi-ta-text .fi-badge {
        font-size: 10px !important;
        padding: 3px 11px !important;
        border-radius: 5px !important;
        background: #00969B;

        color: white;

    }

    .fi-header .fi-header-heading {
        font-size: 24px;
        margin-top: 20px;
    }

    .fi-section-header {
        background-color: #00969B;
        color: white;
        border-top-right-radius: 0.75rem;
        border-top-left-radius: 0.75rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .fi-section-header .fi-section-header-heading {
        color: white;
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 700;

    }

    .fi-fo-field-wrp .fi-input-wrp {
        border-radius: 0.25rem !important;
        box-shadow: none;

    }

    .fi-fo-field-wrp .fi-input-wrp .fi-input {
        font-size: 0.75rem !important;
        line-height: 1rem !important;
        padding-top: 0.625rem !important;
        padding-bottom: 0.625rem !important;
        border-radius: 0.25rem !important;
        border: 1px solid #DBDADE;
        padding-left: 10px;
    }

    .fi-input-wrp .fi-input::placeholder {
        color: black;

    }

    .fi-input-wrp .fi-select-input {
        font-size: 0.75rem !important;
        line-height: 1rem !important;
        padding-top: 0.625rem !important;
        padding-bottom: 0.625rem !important;
        border-radius: 0.25rem !important;
        border: 1px solid #DBDADE;
        ;

    }

    .fi-section-content-ctn .fi-fo-component-ctn {
        gap: 0.5rem;
    }

    .fi-ac .fi-btn {
        background-color: #00969B;
        border-radius: 0.25rem;
        font-weight: 600;
        font-size: 0.75rem;
        line-height: 1rem;
        padding: 0.75rem;
        color: #ffffff
    }

    .fi-ac .fi-btn:hover {
        background: #005974
    }

    .fi-btn {
        background-color: #00969B;
        border-radius: 0.25rem;
        font-weight: 600;
        font-size: 0.75rem;
        line-height: 1rem;
        padding: 0.75rem;
        color: #ffffff
    }

    .fi-btn:hover {
        background: #005974
    }

    .fi-tabs {
        background-color: #00969B;
        border-top-right-radius: 0.75rem;
        border-top-left-radius: 0.75rem;

    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }

    .fi-tabs .fi-tabs-item-active {
        background: white;
        border-radius: 0.25rem;
        font-weight: 600;
        font-size: 0.75rem;
        line-height: 1rem;
        padding: 0.50rem;
        color: #00969B;
    }

    .fi-fo-checkbox-list-option-label .fi-checkbox-input,
    .break-inside-avoid input,
    .fi-fo-field-wrp-label input {
        color: #00969B;
    }

    .fi-fo-rich-editor h2 {
        font-size: 14px;
        border-bottom: 2px solid black;
        padding-bottom: 5px;
        width: fit-content;
    }

    .filepond--hopper {
        border: 2px dashed #00969B;
        box-shadow: none;
        cursor: pointer;

    }

    .filepond--hopper .filepond--drop-label label {
        color: black;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .filament-table-repeater-column button svg {
        height: 15px !important;
    }

    .fi-fo-checkbox-list,
    .fi-fo-radio {
        margin-top: 10px !important;

    }

    .fi-fo-checkbox-list .break-inside-avoid,
    .fi-fo-radio .break-inside-avoid {
        border: 1px solid #00969B;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px !important;

    }
</style>

<script>
    $(document).ready(function() {
        $('#custom-select').select2({
            templateResult: function(data) {
                if (!data.id) {
                    return data.text;
                }
                var cssClass = $(data.element).data('class');
                var $result = $('<span class="' + cssClass + '">' + data.text + '</span>');
                return $result;
            },
            templateSelection: function(data) {
                return data.text;
            }
        });
        $('#custom-select2').select2({
            templateResult: function(data) {
                if (!data.id) {
                    return data.text;
                }
                var cssClass = $(data.element).data('class');
                var $result = $('<span class="' + cssClass + '">' + data.text + '</span>');
                return $result;
            },
            templateSelection: function(data) {
                return data.text;
            }
        });
    });
</script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    window.addEventListener('alert', ({
        detail: {
            type,
            message
        }
    }) => {
        Toast.fire({
            icon: type,
            title: message
        })
    })

</script>


