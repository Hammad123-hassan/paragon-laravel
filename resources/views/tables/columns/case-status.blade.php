
<div >
    @if($getRecord()->case_status == 'Aborted')
        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Aborted</span>
    @elseif($getRecord()->visaDecision && ($getRecord()->visaDecision->status == 'Approved' || $getRecord()->visaDecision->status == 'Refused'))    
    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completed</span>
    @elseif($getRecord()->visaDecision && $getRecord()->visaDecision->status == 'Pending')
    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pending</span> 
    @endif

</div>