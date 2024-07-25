 
  <!-- Circular Progress -->
  <div class="countdown-circle relative size-40">
    <svg class="size-full -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
      <!-- Background Circle -->
      <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-gray-200" stroke-width="2"></circle>
      <!-- Progress Circle -->
      <circle id="circle_offset" cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-600" stroke-width="2" stroke-dasharray="100" stroke-dashoffset="100" stroke-linecap="round"></circle>
    </svg>
  
    <!-- Percentage Text -->
    <div class="absolute top-1/2 start-1/2 transform -translate-y-1/2 -translate-x-1/2">
      <span id="circle_text" class="text-center text-2xl font-bold text-blue-600">0%</span>
    </div>
  </div>
  <!-- End Circular Progress -->