<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400 leading-tight">
            {{ __('CSE-Predictor 1.0 - Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen text-gray-100 font-sans tracking-wide">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome / Alerts -->
            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 text-red-200 p-4 rounded-xl shadow-[0_0_15px_rgba(239,68,68,0.2)] backdrop-blur-md animate-pulse">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Prediction Result Overlay -->
            @if (session('prediction'))
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-100 p-6 rounded-2xl shadow-[0_0_30px_rgba(16,185,129,0.15)] backdrop-blur-lg transform transition hover:scale-[1.01] duration-300">
                    <h3 class="text-xl font-bold mb-2 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Prediction Generated
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <div class="bg-black/40 p-4 rounded-xl border border-gray-700/50">
                            <p class="text-sm text-gray-400 uppercase">Symbol</p>
                            <p class="text-2xl font-black text-white">{{ session('prediction')['symbol'] }}</p>
                        </div>
                        <div class="bg-black/40 p-4 rounded-xl border border-gray-700/50">
                            <p class="text-sm text-gray-400 uppercase">Target Price</p>
                            <p class="text-2xl font-black text-emerald-400">Rs. {{ session('prediction')['predicted_price'] }}</p>
                        </div>
                        <div class="bg-black/40 p-4 rounded-xl border border-gray-700/50">
                            <p class="text-sm text-gray-400 uppercase">Confidence</p>
                            <p class="text-2xl font-black text-blue-400">{{ session('prediction')['confidence'] * 100 }}%</p>
                        </div>
                        <div class="bg-black/40 p-4 rounded-xl border border-gray-700/50">
                            <p class="text-sm text-gray-400 uppercase">Model Engine</p>
                            <p class="text-sm font-semibold text-purple-400 mt-1">{{ session('prediction')['model_used'] }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Prediction Tool -->
                <div class="col-span-1">
                    <div class="bg-gray-800/80 backdrop-blur-xl overflow-hidden shadow-[0_0_40px_rgba(0,0,0,0.5)] sm:rounded-3xl border border-gray-700/50 relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="p-8 relative z-10">
                            <h3 class="text-2xl font-semibold mb-6 text-white tracking-tight">Run Prediction</h3>
                            
                            <form action="{{ route('predict') }}" method="POST" class="space-y-6">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Stock Symbol (e.g., COMB, DIAL)</label>
                                    <input type="text" name="symbol" class="w-full bg-black/50 border border-gray-600 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Enter Symbol..." required>
                                </div>
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-4 px-6 rounded-xl shadow-[0_10px_25px_rgba(79,70,229,0.4)] hover:shadow-[0_15px_35px_rgba(79,70,229,0.5)] transform hover:-translate-y-1 transition-all duration-300">
                                    Analyze & Predict
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Hot Zones -->
                <div class="col-span-1 lg:col-span-2">
                    <div class="bg-gray-800/80 backdrop-blur-xl overflow-hidden shadow-[0_0_40px_rgba(0,0,0,0.5)] sm:rounded-3xl border border-gray-700/50">
                        <div class="p-8">
                            <h3 class="text-2xl font-semibold mb-6 text-white tracking-tight flex items-center gap-2">
                                <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg>
                                CSE Hot Zones (April 2026)
                            </h3>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-black/40 text-gray-400 text-sm uppercase tracking-wider">
                                            <th class="p-4 rounded-tl-xl font-medium">Sector</th>
                                            <th class="p-4 font-medium">Outlook</th>
                                            <th class="p-4 rounded-tr-xl font-medium">Key Note</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700/50">
                                        @foreach ($hotZones as $zone)
                                        <tr class="hover:bg-white/5 transition-colors duration-200">
                                            <td class="p-4 text-white font-medium">{{ $zone['sector'] }}</td>
                                            <td class="p-4">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                                    {{ $zone['outlook'] === 'Bullish' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : '' }}
                                                    {{ $zone['outlook'] === 'Trending' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}
                                                    {{ $zone['outlook'] === 'Recovery Play' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/30' : '' }}
                                                    {{ $zone['outlook'] === 'Stable/Dividends' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : '' }}
                                                ">
                                                    {{ $zone['outlook'] }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-gray-300 text-sm">{{ $zone['note'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
