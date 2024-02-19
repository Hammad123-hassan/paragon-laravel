<div class="">
    <div class="-lg">
        <!-- Content Header (Page header) -->
        <section class="bg-white py-3 px-4  ">
            <div class="container mx-auto">
                <div class="flex items-center justify-between ">
                    <div class="w-1/2">
                        @if ($viewStatus)
                        <button wire:click="listView"
                            class="p-3 rounded text-xs font-semibold text-white bg-[#00969B] hover:bg-[#005974]">List
                            Account</button>
                        @else
                        <button wire:click="ListAdd"
                            class="p-3 rounded text-xs font-semibold text-white bg-[#00969B] hover:bg-[#005974] ">
                            Create New
                            Account</button>
                        @endif
                    </div>
                    <div class="w-1/2">
                        <ol class="flex items-center  text-gray-600 text-sm float-right md:gap-3 gap-1">
                            <li><a href="{{ '/' }}"
                                    class="text-blue-500 font-semibold md:text-sm text-[10px]">Dashboard</a></li> /
                            <li class="whitespace-nowrap md:text-sm text-[10px]">Chart of Account</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class=" ">
            <div class="container mx-auto">
                <div class="">
                    <div>
                       @include('livewire.message.success')
                       @include('livewire.message.error')
                    </div>
                    @if ($viewStatus)
                    <div class="flex ">
                        <div class="w-full">
                            <div class="bg-white ">
                                <div class="p-3 px-4 border-b border-gray-200 bg-[#00969B] text-white font-semibold text-sm">
                                    <h3 class="text-base text-white-700 flex gap-3 items-center">
                                        <i class="fa fa-book"></i> Chart of Account
                                    </h3>
                                </div>
                                <div class="">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 p-4 mb-3">
                                        <div class="">
                                            <label for="levelFilter" class="block text-xs font-medium text-[#4B465C] mb-1.5">Filter Level</label>
                                            <select id="levelFilter" wire:model="levelFilter" class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs">
                                                <option value="">None</option>
                                                <option value="1">Level 1</option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <label for="parent_chart_of_account_id" class="block text-xs font-medium text-[#4B465C] mb-1.5">Parent Account</label>
                                            <select id="parent_chart_of_account_id" wire:model="record.parent_chart_of_account_id" class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs">
                                                <option value="">None</option>
                                                @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('record.parent_chart_of_account_id')
                                            <span class="text-red-500 text-sm">Field is required</span>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <label for="record.title" class="block text-xs font-medium text-[#4B465C] mb-1.5">Account Title</label>
                                            <input type="text" wire:model="record.title" class="form-input border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs">
                                            @error('record.title')
                                            <span class="text-red-500 text-sm">Field is required</span>
                                            @enderror
                                        </div>
                                        <!-- Add the new fields for branch_id and category here -->
                                        <div class="">
                                            <label for="record.show" class="block text-xs font-medium text-[#4B465C] mb-1.5">Show</label>
                                            <select id="record.show" wire:model="record.show"
                                                    class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs">
                                                <option value="">Select Show</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                            @error('record.show')
                                            <span class="text-red-500 text-sm">Field is required</span>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <label for="record.category" class="block text-xs font-medium text-[#4B465C] mb-1.5">Category</label>
                                            <select id="record.category" wire:model="record.category" class="form-select border-[#DBDADE] border rounded w-full p-2 py-2.5  text-[#040404] text-xs">
                                                <option value="">Select Category</option>
                                                <option value="Balance Sheet">Balance Sheet</option>
                                                <option value="P&L">P&L</option>
                                            </select>
                                            @error('record.category')
                                            <span class="text-red-500 text-sm">Field is required</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="" v-if="isLastLevel">
                                        <div class="">
                                            <h4 class="mb-4  p-3 px-4 border-b border-gray-200 bg-[#00969B] ">
                                                <b class="text-white font-semibold text-sm flex gap-3 items-center"><i class="fa-solid fa-user"></i>Account
                                                    type</b>
                                            </h4>
                                            <div class="flex items-center mb-2 px-4">
                                                <input type="radio" id="normal" wire:model="record.account_type"
                                                    value="normal">
                                                <label for="normal"
                                                    class="ml-2 mb-0  text-sm font-medium text-[#4B465C]">Normal</label>
                                            </div>
                                            <div class="flex items-center mb-2 px-4">
                                                <input type="radio" id="bank" wire:model="record.account_type"
                                                    value="bank">
                                                <label for="bank"
                                                    class="ml-2 mb-0  text-sm font-medium text-[#4B465C]">Bank</label>
                                            </div>
                                            <div class="flex items-center px-4">
                                                <input type="radio" id="cash" wire:model="record.account_type"
                                                    value="cash">
                                                <label for="cash"
                                                    class="ml-2 mb-0  text-sm font-medium text-[#4B465C]">Cash</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" text-right">
                                        @if (isset($data['id']))
                                        <button wire:loading.attr='disabled' wire:click="update" type="submit"
                                            class="btn btn-warning btn-my-lg">
                                            Update
                                            <div wire:loading wire:target="update"
                                                class="spinner-border spinner-border-sm" role="status">
                                            </div>
                                        </button>
                                        @else
                                        <button wire:loading.attr='disabled' wire:click="createAccount" type="submit"
                                            class="p-3 rounded text-xs font-semibold text-white bg-[#00969B] hover:bg-[#005974] m-3">
                                            Submit
                                            <div wire:loading wire:target="createAccount"
                                                class="spinner-border spinner-border-sm" role="status">
                                            </div>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="flex py-6 px-4 pt-2 ">
                        <div class="flex ">
                            <div class="w-full">
                                <ul class="listree">
                                    @foreach ($mainAccounts as $levelOne)
                                    <li>
                                        <div data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            wire:click="editAccount({{ $levelOne }})"
                                            class="text-red-500 cursor-pointer">
                                            <b class="mr-2">{{ $levelOne->account_number }}</b>
                                            {{ $levelOne->title }}
                                        </div>
                                        <ul class="listree-submenu-items" v-if="levelOne.sub_accounts.length">
                                            @foreach ($levelOne->subAccounts as $levelTwo)
                                            <li>
                                                <div data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    wire:click="editAccount({{ $levelTwo }})"
                                                    class="text-info cursor-pointer mr-2 text-[#005974] font-semibold text-sm mb-1">
                                                    <b
                                                        class="mr-2 text-[#00969B] font-bold text-sm">{{ $levelTwo->account_number }}</b>
                                                    {{ $levelTwo->title }}
                                                </div>
                                                @if (count($levelTwo->subAccounts) > 0)
                                                <ul class="listree-submenu-items">
                                                    @foreach ($levelTwo->subAccounts as $levelThree)
                                                    <li class="text-primary">
                                                        <div data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="editAccount({{ $levelThree }})"
                                                        class="font-normal text-xs cursor-pointer text-[#005974] mb-1">
                                                        <b class="mr-2 text-[#00969B] font-semibold text-xs">{{ $levelThree->account_number }}</b>
                                                        {{ $levelThree->title }}
                                                    
                                                        @if ($levelThree->category)
                                                            <span class="text-[#9CA3AF] text-xs"> ({{ $levelThree->category }})</span>
                                                        @endif
                                                    </div>                                                    

                                                        @if (count($levelThree->subAccounts))
                                                        <ul class="listree-submenu-items">
                                                            @foreach ($levelThree->subAccounts as $levelFour)
                                                            <li data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                wire:click="editAccount({{ $levelFour }})"
                                                                class="text-success cursor-pointer">
                                                                <b class="mr-2">{{ $levelFour->account_number }}</b>
                                                                {{ $levelFour->title }}
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</div>
