<div class="fixed bottom-0 left-0 z-40 w-full h-16 bg-white border-t border-gray-200">
    <div class="grid h-full max-w-lg grid-cols-3 mx-auto font-medium">
        <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
            <i class="fa-solid fa-home mb-2 text-gray-500 group-hover:text-mineral-green-600"></i>
            <span class="text-sm text-gray-500 group-hover:text-mineral-green-600">Home</span>
        </button>
        <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
            <i class="fa-solid fa-file mb-2 text-gray-500 group-hover:text-mineral-green-600"></i>
            <span class="text-sm text-gray-500 group-hover:text-mineral-green-600">Report</span>
        </button>
        <form action="{{ route('logout') }}" method="post"
            class="inline-flex items-center justify-center px-5 hover:bg-gray-50 group">
            @csrf
            @method('POST')
            <button type="submit" class="inline-flex flex-col items-center justify-center">
                <i class="fa-solid fa-right-from-bracket mb-2 text-gray-500 group-hover:text-mineral-green-600"></i>
                <span class="text-sm text-gray-500 group-hover:text-mineral-green-600">Logout</span>
            </button>
        </form>
    </div>
</div>
