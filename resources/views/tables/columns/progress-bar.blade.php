<script src="https://cdn.tailwindcss.com"></script>
<div class="w-full bg-gray-200 rounded-full dark:bg-gray-700" style="padding-left: 0px;">
  <style>

    .progress-done {
      background:   #00969B;
        border-radius: 20px;
       
    }
</style>
    @php
        $statuses = config('status');
        $currentStatus = $getRecord()->status;
        $statusIndex = array_search($currentStatus, array_keys($statuses));
        if ($currentStatus == 'VISA DECISION' && $getRecord()->visaDecision && $getRecord()->visaDecision->status == 'Pending'){
          $progressPercentage = 88;
        }
        else{
          $progressPercentage = $statusIndex / (count($statuses) - 1) * 100;
        }
      
        // $progressPercentage = $statusIndex / (count($statuses) - 1) * 100;
    @endphp
    <div  class="progress-done text-xs font-medium text-green-100 text-center p-0.5 leading-none rounded-full" style="width: {{ round($progressPercentage) }}%"> {{ round($progressPercentage) }}%</div>

</div>