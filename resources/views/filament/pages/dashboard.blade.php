<x-filament-panels::page>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="md:grid md:grid-cols-5 gap-3">
        <div class="col-span-3 flex items-center rounded-xl  sm:py-4 sm:pr-2 sm:pl-4 p-2 shadow-sm" style="background: linear-gradient(208deg, rgba(0,151,156,1) 0%, rgba(0,89,116,1) 78%);">
            <div class="xl:w-1/2 sm:w-3/5">
                <div class="lg:mb-10 mb-5">
                    <h1 class="sm:text-2xl text-lg text-white font-semibold mb-1">
                        Paragon CMS
                    </h1>
                    <p class="text-xs text-white font-normal">
                        A Whole World of Opportunities Awaits You.
                    </p>
                </div>
                <div>
                    <p class="text-sm text-white font-normal pb-4">Analytics</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex sm:gap-3 gap-1 items-center">
                            <span
                                class="bg-[#00969B] 2xl:py-2 sm:py-2 sm:px-2 p-1 2xl:px-2 flex justify-center items-center lg:px-2 font-semibold rounded text-white sm:text-sm text-[10px] xl:max-w-[60px] xl:w-[60px] lg:max-w-[40px] lg:w-[40px] max-w-[30px] w-[30px]">{{ $branches }}</span>
                            <p class="text-white sm:text-sm text-xs">Branches</p>
                        </div>
                        <div class="flex sm:gap-3 gap-1 items-center">
                            <span
                                class="bg-[#00969B] 2xl:py-2 sm:py-2 sm:px-2 p-1 2xl:px-2  flex justify-center items-center lg:px-2 font-semibold rounded text-white sm:text-sm text-[10px] xl:max-w-[60px] xl:w-[60px] lg:max-w-[40px] lg:w-[40px] max-w-[30px] w-[30px]">{{ $countries }}</span>
                            <p class="text-white sm:text-sm text-xs">Countries</p>
                        </div>
                        <div class="flex sm:gap-3 gap-1 items-center">
                            <span
                                class="bg-[#00969B] 2xl:py-2 sm:py-2 sm:px-2 p-1 2xl:px-2 flex justify-center items-center lg:px-2 font-semibold rounded text-white sm:text-sm text-[10px] xl:max-w-[60px] xl:w-[60px] lg:max-w-[40px] lg:w-[40px] max-w-[30px] w-[30px]">{{ $users }}</span>
                            <p class="text-white sm:text-sm text-xs">Users</p>
                        </div>

                        <div class="flex sm:gap-3 gap-1 items-center">
                            <span
                                class="bg-[#00969B] 2xl:py-2 sm:py-2 sm:px-2 p-1 2xl:px-2 flex justify-center items-center lg:px-2 font-semibold rounded text-white sm:text-sm text-[10px] xl:max-w-[60px] xl:w-[60px] lg:max-w-[40px] lg:w-[40px] max-w-[30px] w-[30px]">{{ $universities }}</span>
                            <p class="text-white sm:text-sm text-xs">Universities</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xl:w-1/2 sm:w-2/5">
                <img src="/cms-img.png" alt="" class="h-full w-full">
            </div>
        </div>
        <div class="col-span-2 rounded-xl  py-4 lg:pr-2 lg:pl-4 px-2 shadow-sm md:mt-0 mt-5 border border-[#E5E7EB] bg-white"">
            <div class="lg:mb-10 mb-5">
                <div class="flex justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <img src="/Totaluser-icon.svg" class="bg-[#2B409A] p-2 rounded-xl "
                                alt="" />
                            <p class="text-[#A5A2AD] font-normal text-base">
                                Total Cases
                            </p>
                        </div>
                        <span class="sm:text-2xl text-base text-[#5D586C] font-semibold">{{ $totalCase }}</span>
                    </div>
                    {{-- <div>
                        <input type="month" class="text-xs rounded-md p-2 bg-[#E4E3E7] w-full" wire:model.live='monthWise' value="{{ now()->format('Y-m') }}"/>
                    </div> --}}
                    <div>
                      <select class="text-xs rounded-md p-2 bg-[#E4E3E7] w-full" wire:model.live="intake_id">
                          <option value="">Select Intake</option>
                          @foreach ($intakes as $intake)
                              <option value="{{ $intake->id }}">{{ $intake->name }}</option>
                          @endforeach
                      </select>
                  </div>
                </div>
            </div>
            <div class="flex items-center gap-1 lg:mb-10 mb-5">
                <div class="relative cms-values w-1/3">
                    <div class="gap-2 flex items-center mb-2">
                        <img src="/tick-icon.svg" class="bg-[#34B10B] rounded-md p-1" alt="" />
                        <p class="xl:text-sm text-sm md:text-[10px] text-[#5D586C] font-normal">
                            Completed
                        </p>
                    </div>
                    <span class="text-lg font-semibold text-[#5D586C]">{{ $completedCase }}</span>
                </div>
                <div class="relative cms-value w-1/3">
                    <div class="gap-2 flex items-center mb-2">
                        <img src="/attach-icon.svg" class="bg-[#E87D00] rounded-md p-1" alt="" />
                        <p class="xl:text-sm text-sm md:text-[10px] text-[#5D586C] font-normal">
                            Ongoing
                        </p>
                    </div>
                    <span class="text-lg font-semibold text-[#5D586C]">{{ $ongoing }}</span>
                </div>
                <div class="lg:w-1/3">
                    <div class="gap-2 flex items-center mb-2">
                        <img src="/close-icon.svg" class="bg-[#F50100] rounded-md p-2" alt="" />
                        <p class="xl:text-sm text-sm md:text-[10px] text-[#5D586C] font-normal">
                            Aborted
                        </p>
                    </div>
                    <span class="text-lg font-semibold text-[#5D586C]">{{ $aborted }}</span>
                </div>
            </div>
            <div class="flex items-center">
                <span class="bg-[#34B10B] w-1/3 rounded-l-lg h-2"></span>
                <span class="bg-[#E87D00] w-1/3 h-2"></span>
                <span class="bg-[#F50100] w-1/3 rounded-r-lg h-2"></span>
            </div>
        </div>
        <div class="col-span-2 rounded-xl  py-4 pt-0 shadow-sm max-h-[473px] overflow-y-auto md:mt-0 mt-5 border border-[#E5E7EB] bg-white">
          <div class="fi-ta-header flex flex-col gap-3 p-4 sm:px-6 sm:flex-row sm:items-center border-b border-[#E5E7EB]">
            <h1 class="fi-ta-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">Notifications</h1>
          </div>
            <div class="flex justify-between  items-center border-[#ccccccc] border-b-2 sm:pb-3 sm:pt-3 sm:pr-4 sm:pl-4 p-2">
              <div class="flex items-start gap-2">
                <div>
                   <img src="/notification-user.svg" alt="img" class="mt-[8px]">
                </div>
                <div>
                  <span class="sm:text-xs text-[10px] font-medium">Hammad's case registerd.</span>
                  <p class=" text-[10px] max-w-[230px]">
                    Admission Application has been submitted for -Hamza Author
                    for this change -Super Admin
                  </p>
                </div>
              </div>
              <div>
                <p class="text-[8px] ">2023-09-08</p>
              </div>
            </div>
            <div class="flex justify-between  items-center border-[#ccccccc] border-b-2 sm:pb-3 sm:pt-3 sm:pr-4 sm:pl-4 p-2">
              <div class="flex items-start gap-2">
                <div>
                   <img src="/notification-user.svg" alt="img" class="mt-[8px]">
                </div>
                <div>
                  <span class="sm:text-xs text-[10px] font-medium">John's Case Aborted.</span>
                  <p class=" text-[10px] max-w-[230px]">
                    Admission Application has been submitted for -Hamza Author
                    for this change -Super Admin
                  </p>
                </div>
              </div>
              <div>
                <p class="text-[8px] ">2023-09-08</p>
              </div>
            </div>
            <div class="flex justify-between  items-center border-[#ccccccc] border-b-2 sm:pb-3 sm:pt-3 sm:pr-4 sm:pl-4 p-2">
              <div class="flex items-start gap-2">
                <div>
                   <img src="/notification-user.svg" alt="img" class="mt-[8px]">
                </div>
                <div>
                  <span class="sm:text-xs text-[10px] font-medium">John's Case Aborted.</span>
                  <p class=" text-[10px] max-w-[230px]">
                    Admission Application has been submitted for -Hamza Author
                    for this change -Super Admin
                  </p>
                </div>
              </div>
              <div>
                <p class="text-[8px] ">2023-09-08</p>
              </div>
            </div><div class="flex justify-between  items-center border-[#ccccccc] border-b-2 sm:pb-3 sm:pt-3 sm:pr-4 sm:pl-4 p-2">
              <div class="flex items-start gap-2">
                <div>
                   <img src="/notification-user.svg" alt="img" class="mt-[8px]">
                </div>
                <div>
                  <span class="sm:text-xs text-[10px] font-medium">John's Case Aborted.</span>
                  <p class=" text-[10px] max-w-[230px]">
                    Admission Application has been submitted for -Hamza Author
                    for this change -Super Admin
                  </p>
                </div>
              </div>
              <div>
                <p class="text-[8px] ">2023-09-08</p>
              </div>
            </div>

            <div class="flex justify-between  items-center border-[#ccccccc] border-b-2 sm:pb-3 sm:pt-3 sm:pr-4 sm:pl-4 p-2">
              <div class="flex items-start gap-2">
                <div>
                   <img src="/notification-user.svg" alt="img" class="mt-[8px]">
                </div>
                <div>
                  <span class="sm:text-xs text-[10px] font-medium">Sarah's Visa Granted.</span>
                  <p class=" text-[10px] max-w-[230px]">
                    Admission Application has been submitted for -Hamza Author
                    for this change -Super Admin
                  </p>
                </div>
              </div>
              <div>
                <p class="text-[8px] ">2023-09-08</p>
              </div>
            </div>

            <div class="flex justify-between sm:items-start items-center sm:pt-3 sm:pr-4 sm:pl-4 p-2">
              <div class="flex flex items-start gap-2">
                <div>
                   <img src="/notification-user.svg" alt="img" class="mt-[8px]">
                </div>
                <div>
                  <span class="sm:text-xs text-[10px] font-medium">Emily Employee Registered.</span>
                  <p class=" text-[10px] max-w-[230px]">
                    Admission Application has been submitted for -Hamza Author
                    for this change -Super Admin
                  </p>
                </div>
              </div>
              <div>
                <p class="text-[8px] ">2023-09-08</p>
              </div>
            </div>
            <div class="flex justify-between sm:items-start items-center sm:pt-3 sm:pr-4 sm:pl-4 p-2">
              <div class="flex flex items-start gap-2">
                <div>
                   <img src="/notification-user.svg" alt="img" class="mt-[8px]">
                </div>
                <div>
                  <span class="sm:text-xs text-[10px] font-medium">Sarah Terminated from role.</span>
                  <p class=" text-[10px] max-w-[230px]">
                    Admission Application has been submitted for -Hamza Author
                    for this change -Super Admin
                  </p>
                </div>
              </div>
              <div>
                <p class="text-[8px] ">2023-09-08</p>
              </div>
            </div>
          </div>
        <div class="col-span-3 md:mt-0 mt-5">
            @livewire(\App\Filament\Widgets\CaseRegister::class)
        </div>


    </div>
 
</x-filament-panels::page>
