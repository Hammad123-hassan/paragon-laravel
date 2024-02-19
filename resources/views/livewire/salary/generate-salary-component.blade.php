<div class="">
    <style>

    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header ">
        <div class="container mx-auto">
            <div class="flex items-center gap-3 py-3 px-4  rounded-tr-lg rounded-tl-lg bg-[#00969B]">
                <img src="/salary.svg" alt="" class="h-[30px]">
                <h1 class="breadcrumb-item text-sm text-white text-center  font-bold">Generate Salary</h1>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container mx-auto">
            <div>
                @include('livewire.message.success')
                @include('livewire.message.error')
            </div>
            <div class="flex">

                <div class="w-full bg-white">
                    <div class="card card-custom card-outline">
                        <div
                            class="card-header p-4 py-3 border-b border-gray-200 text-black bg-white font-semibold text-xs ">
                            <h3 class="card-title text-sm font-bold">
                                Salary Slip Details
                            </h3>
                        </div>
                        <div class="card-body  table-responsive bg-white pb-4">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 p-4">
                                <div class="col-span-6">
                                    <div class="form-group">
                                        @if ($errors->has('data.voucher_date'))
                                        <label class="col-form-label" for="inputError" class="text-red-500">
                                            <i class="far fa-times-circle"></i>
                                            {{ $errors->first('data.voucher_date') }}
                                        </label>
                                        @else
                                        <label for="voucher_date"
                                            class="block text-xs font-medium text-[#4B465C] mb-1.5">Years
                                        </label>
                                        @endif
                                        <select wire:model.live='year'
                                            class="form-input border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs">
                                            <option selected>Choose a year</option>
                                            @for ($year = 2023; $year <= date("Y"); $year++) <option
                                                value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                        </select>
                                        @error('year')
                                        {{ $message }}
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-span-6">
                                    <div class="form-group">
                                        @if ($errors->has('data.voucher_date'))
                                        <label class="col-form-label" for="inputError" class="text-red-500">
                                            <i class="far fa-times-circle"></i>
                                            {{ $errors->first('data.voucher_date') }}
                                        </label>
                                        @else
                                        <label for="voucher_date"
                                            class="block text-xs font-medium text-[#4B465C] mb-1.5">Months
                                        </label>
                                        @endif
                                        <select wire:model.live='month'
                                            class="form-input border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs">

                                            <option value="">Select</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>

                                        </select>
                                        @error('month')
                                        {{ $message }}
                                        @enderror

                                    </div>
                                </div>
                            </div>



                            @if($month && $year)
                            <div class=" mx-4 overflow-x-auto ">
                                <table class="table table-hover w-full whitespace-nowrap">
                                    <thead>
                                        <tr class="rounded">

                                            <th class="text-start p-3 py-4 text-white  bg-[#00969B] rounded-tl-lg
                                                  font-semibold text-xs border-[#E5E7EB] border border-l-0 border-t-0">
                                                ID</th>
                                            <th
                                                class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                Name </th>
                                            <th
                                                class="text-start p-3 py-4 text-white  bg-[#00969B] font-semibold text-xs border border-[#E5E7EB]">
                                                Salary</th>
                                            <th
                                                class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border border-[#E5E7EB]">
                                                Bank</th>
                                            <th
                                                class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border border-[#E5E7EB]">
                                                Account Number</th>
                                            <th
                                                class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border border-[#E5E7EB]">
                                                Deduction </th>
                                            <th
                                                class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border border-[#E5E7EB]">
                                                Bonus </th>
                                            <th
                                                class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border border-[#E5E7EB]">
                                                Total Salary </th>
                                            <th
                                                class="text-start  p-3 py-4 text-white  bg-[#00969B]  font-semibold text-xs border rounded-tr-lg border-r-0 border-t-0 border-[#E5E7EB]">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr class="">
                                            <td class="text-start p-3  font-semibold text-xs  border">
                                                {{ $user->id }}</td>
                                            <td class="text-start p-3  font-semibold text-xs  border">
                                                {{ $user->name }}
                                                <span
                                                    class="text-[10px]">({{ $user->roles->pluck('name')->first() }})</span>
                                            </td>
                                            <td class="text-start p-3  font-semibold text-xs  border">
                                                {{number_format($user->salary, 2) }}
                                            </td>
                                            <td class="text-start p-3  font-semibold text-xs   border">
                                                {{ $user->bank }}</td>
                                            <td class="text-start p-3  font-semibold text-xs   border">
                                                {{ $user->account_no }}</td>
                                                <td class="text-start p-3 font-semibold w-[100px] max-w-[100px] border">
                                                  
                                                
                                                    <input wire:model.live='deduction.{{ $user->id }}' type="number"
                                                        class="border-[#00969B] border rounded w-full text-xs focus:border-none focus:shadow-none"
                                                       >
                                                </td>
                                                
                                                <td class="text-start p-3 font-semibold w-[100px] max-w-[100px] border">
                                                    
                                                
                                                    <input wire:model.live='bonus.{{ $user->id }}' type="number"
                                                        class="border-[#00969B] border rounded text-xs w-full focus:border-none focus:shadow-none"
                                                       >
                                                </td>
                                                
                                            <td class="text-start p-3  font-semibold text-xs   border">
                                                {{number_format(((float)$user->salary - (float)$deduction[$user->id] ) + (float)$bonus[$user->id], 2) }}
                                            </td>
                                            <td class="text-start p-3 border border-l-0 ">
                                                
                                                    <button wire:click="openModal('{{ $user->id }}')" 
                                                        class="bg-[#00969B] text-xs text-white p-2 py-1 rounded">Paid</button>
                                               

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="flex justify-end mt-4">
                                    <button wire:click='store'
                                        class="p-3 rounded text-xs font-semibold text-white  bg-[#00969B] hover:bg-[#005974]">Save</button>
                                </div>
                            </div>
                            @endif


                        </div>
                        <!-- /.card body -->
                    </div>
                </div>

                <!-- /.col -->
            </div>
            <!-- ./row -->
        </div><!-- /.container -->
    </section>
    <!-- /.content -->
    <!-- Main modal -->
    <div wire:ignore.self id="default-modal"  tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 pb-0 md:p-5 md:pb-0 rounded-t dark:border-gray-600">

                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-4 md:px-1 space-y-4 flex items-center justify-center">
                    <p class="font-normal text-xl text-center max-w-[310px]">Is the payment of the salary confirmed?</p>
                </div>
                <!-- Modal footer -->
               <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 rounded-b dark:border-gray-600 justify-center gap-3">
                    <button data-modal-hide="default-modal" type="button" class="p-3 rounded text-xs font-semibold text-white bg-[#00969B] hover:bg-[#005974] hover:text-white"
                            wire:click="paidMark('{{ $userId }}')">Confirm</button>
                    <button data-modal-hide="default-modal" type="button" wire:click="$dispatch('closeModal')"
                            class="p-3 rounded text-xs font-semibold text-[#00969B] bg-white border-[#00969B] border hover:bg-[#005974] hover:text-white">Cancel</button>
                </div>

            </div>
        </div>
    </div>
   <!-- Livewire script with Alpine.js -->
<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('openModal', (event) => {  
            document.getElementById('default-modal').classList.remove('hidden');
        });

        // Close the modal when the "Confirm" or "Cancel" buttons are clicked
        document.getElementById('default-modal').addEventListener('click', function (event) {
            if (event.target.hasAttribute('data-modal-hide')) {
                document.getElementById('default-modal').classList.add('hidden');
            }
        });
    });
</script>

</div>
