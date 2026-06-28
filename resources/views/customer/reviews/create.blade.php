<x-public-layout>
    <x-slot name="title">Share Your Feedback - OkhlaFlat</x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>

            <!-- Review Card container -->
            <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden p-8">
                <!-- Summary of Visit -->
                <div class="border-b border-slate-100 pb-6 mb-6">
                    <span class="block text-[10px] text-indigo-600 font-bold uppercase tracking-wider mb-1">Feedback For Your Visit</span>
                    @if($visit->property)
                        <h3 class="text-xl font-bold text-slate-950">{{ $visit->property->title }}</h3>
                        <p class="text-xs text-slate-400 mt-1.5 font-medium">
                            Property Code: <span class="font-bold text-slate-600">{{ $visit->property->property_code }}</span> • Locality: {{ $visit->property->locality->name }}
                        </p>
                    @else
                        <h3 class="text-xl font-bold text-slate-950">General Office Consultation</h3>
                        <p class="text-xs text-slate-400 mt-1.5 font-medium">Physical office visit to explore rental listings</p>
                    @endif

                    @if($visit->agent)
                        <div class="mt-4 flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center text-xs font-bold uppercase">
                                {{ substr($visit->agent->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Assigned Agent</p>
                                <p class="text-sm font-bold text-slate-800">{{ $visit->agent->name }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Review Form -->
                <form action="{{ route('customer.reviews.store', $visit) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- 1. Property Rating -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">Rate the Flat / Property</label>
                        <p class="text-xs text-slate-400 mb-3">How was the location, layout, maintenance, and description accuracy?</p>
                        
                        <div class="flex items-center gap-1.5" id="property-rating-container">
                            @foreach(range(1, 5) as $i)
                                <button type="button" data-rating="{{ $i }}" class="star-btn text-slate-200 hover:scale-110 transition-transform duration-100" data-type="property">
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </button>
                            @endforeach
                            <input type="hidden" name="property_rating" id="property_rating_input" required value="">
                        </div>
                        @error('property_rating')
                            <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2. Agent Rating -->
                    @if($visit->agent)
                        <div class="border-t border-slate-100 pt-6">
                            <label class="block text-sm font-bold text-slate-800 mb-2">Rate Agent ({{ $visit->agent->name }})</label>
                            <p class="text-xs text-slate-400 mb-3">How helpful, punctual, professional, and knowledgeable was your agent?</p>
                            
                            <div class="flex items-center gap-1.5" id="agent-rating-container">
                                @foreach(range(1, 5) as $i)
                                    <button type="button" data-rating="{{ $i }}" class="star-btn text-slate-200 hover:scale-110 transition-transform duration-100" data-type="agent">
                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </button>
                                @endforeach
                                <input type="hidden" name="agent_rating" id="agent_rating_input" value="">
                            </div>
                            @error('agent_rating')
                                <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- 3. Comments -->
                    <div class="border-t border-slate-100 pt-6">
                        <label for="comment" class="block text-sm font-bold text-slate-800 mb-2">Write a Review (Optional)</label>
                        <p class="text-xs text-slate-400 mb-3">Share details of your experience to help future buyers and landlords.</p>
                        <textarea name="comment" id="comment" rows="4" placeholder="Describe your experience in detail..." class="block w-full rounded-xl border-slate-200/85 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3"></textarea>
                        @error('comment')
                            <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md shadow-indigo-100 hover:shadow-lg duration-200">
                        Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Star Rating Logic JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const starButtons = document.querySelectorAll('.star-btn');
            
            starButtons.forEach(button => {
                const type = button.dataset.type; // 'property' or 'agent'
                const container = document.getElementById(`${type}-rating-container`);
                const input = document.getElementById(`${type}_rating_input`);
                const stars = container.querySelectorAll('.star-btn');
                
                // Hover effect: highlight stars up to hovered star
                button.addEventListener('mouseenter', () => {
                    const rating = parseInt(button.dataset.rating);
                    highlightStars(stars, rating, 'text-amber-300', 'text-slate-200');
                });
                
                // Mouse leave: reset to currently selected rating
                button.addEventListener('mouseleave', () => {
                    const selectedRating = parseInt(input.value) || 0;
                    highlightStars(stars, selectedRating, 'text-amber-400', 'text-slate-200');
                });
                
                // Click: set value and persist highlight
                button.addEventListener('click', () => {
                    const rating = parseInt(button.dataset.rating);
                    input.value = rating;
                    highlightStars(stars, rating, 'text-amber-400', 'text-slate-200');
                });
            });

            function highlightStars(starsList, rating, activeClass, inactiveClass) {
                starsList.forEach(star => {
                    const currentStarRating = parseInt(star.dataset.rating);
                    if (currentStarRating <= rating) {
                        star.classList.remove(inactiveClass);
                        star.classList.add(activeClass);
                    } else {
                        star.classList.remove(activeClass);
                        star.classList.add(inactiveClass);
                    }
                });
            }
        });
    </script>
</x-public-layout>
