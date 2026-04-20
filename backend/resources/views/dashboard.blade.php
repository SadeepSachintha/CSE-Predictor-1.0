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
                    <h3 class="text-xl font-bold mb-2 flex items-center gap-3">
                        <div class="relative flex items-center justify-center w-10 h-10 rounded-full bg-emerald-500/20 border border-emerald-500/50">
                            <svg class="w-6 h-6 text-emerald-400 drop-shadow-[0_0_8px_rgba(52,211,153,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        Prediction Generated
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <div class="bg-black/40 p-4 rounded-xl border border-gray-700/50 hover:bg-black/60 transition-colors group">
                            <p class="text-sm text-gray-400 uppercase flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                Symbol
                            </p>
                            <p class="text-2xl font-black text-white mt-1">{{ session('prediction')['symbol'] }}</p>
                        </div>
                        <div class="bg-black/40 p-4 rounded-xl border border-gray-700/50 hover:bg-black/60 transition-colors group">
                            <p class="text-sm text-gray-400 uppercase flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Target Price
                            </p>
                            <p class="text-2xl font-black text-emerald-400 mt-1">Rs. {{ session('prediction')['predicted_price'] }}</p>
                        </div>
                        <div class="bg-black/40 p-4 rounded-xl border border-gray-700/50 hover:bg-black/60 transition-colors group">
                            <p class="text-sm text-gray-400 uppercase flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Confidence
                            </p>
                            <p class="text-2xl font-black text-blue-400 mt-1">{{ session('prediction')['confidence'] * 100 }}%</p>
                        </div>
                        <div class="bg-black/40 p-4 rounded-xl border border-gray-700/50 hover:bg-black/60 transition-colors group">
                            <p class="text-sm text-gray-400 uppercase flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500 group-hover:text-purple-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                Model Engine
                            </p>
                            <p class="text-sm font-semibold text-purple-400 mt-1">{{ session('prediction')['model_used'] }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Market Watch - Equity (Atrad Style) -->
            <div class="bg-[#111111] border border-gray-800 rounded-lg shadow-xl overflow-hidden font-mono text-xs text-gray-300">
                <div class="bg-gradient-to-b from-[#2a2a2a] to-[#1c1c1c] border-b border-gray-700 px-4 py-2 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span class="text-white font-semibold">Market Watch - Full Watch - Equity</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div> Market : Open</span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-[#1a1a1a] text-gray-400 border-b border-gray-800">
                                <th class="p-2 text-left font-normal border-r border-gray-800">Security</th>
                                <th class="p-2 text-left font-normal border-r border-gray-800">Company Name</th>
                                <th class="p-2 font-normal">Bid Qty</th>
                                <th class="p-2 font-normal text-yellow-500">Bid Price</th>
                                <th class="p-2 font-normal text-red-400">Ask Price</th>
                                <th class="p-2 font-normal">Ask Qty</th>
                                <th class="p-2 font-normal text-green-400 border-l border-gray-800">Last</th>
                                <th class="p-2 font-normal">Last Qty</th>
                                <th class="p-2 font-normal">Change</th>
                                <th class="p-2 font-normal">% Change</th>
                                <th class="p-2 font-normal">High</th>
                                <th class="p-2 font-normal border-r border-gray-800">Low</th>
                                <th class="p-2 font-normal">Volume</th>
                                <th class="p-2 font-normal text-center">Trades</th>
                                <th class="p-2 font-normal text-center">Buy Sentiment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800" id="market-watch-body">
                            @if(isset($marketWatchData) && count($marketWatchData) > 0)
                                @foreach($marketWatchData as $row)
                                    @php
                                        $isPositive = floatval($row['Change']) > 0;
                                        $isNegative = floatval($row['Change']) < 0;
                                        $colorClass = $isPositive ? 'text-green-500' : ($isNegative ? 'text-red-500' : 'text-gray-400');
                                    @endphp
                                    <tr class="hover:bg-[#202020] transition-colors">
                                        <td class="p-2 text-left text-white border-r border-gray-800">{{ $row['Symbol'] }}</td>
                                        <td class="p-2 text-left text-gray-400 truncate max-w-[150px] border-r border-gray-800">{{ $row['CompanyName'] }}</td>
                                        <td class="p-2">{{ number_format($row['BidQty']) }}</td>
                                        <td class="p-2 text-green-400 font-medium">{{ $row['BidPrice'] }}</td>
                                        <td class="p-2 text-red-400 font-medium">{{ $row['AskPrice'] }}</td>
                                        <td class="p-2">{{ number_format($row['AskQty']) }}</td>
                                        <td class="p-2 {{ $colorClass }} font-semibold border-l border-gray-800">
                                            {{ $row['Last'] }}
                                            @if($isPositive)
                                                <span class="inline-block transform -translate-y-0.5">▲</span>
                                            @elseif($isNegative)
                                                <span class="inline-block transform translate-y-0.5">▼</span>
                                            @endif
                                        </td>
                                        <td class="p-2">{{ number_format($row['LastQty']) }}</td>
                                        <td class="p-2 {{ $colorClass }}">{{ $row['Change'] }}</td>
                                        <td class="p-2 {{ $colorClass }}">{{ $row['ChangePct'] }}</td>
                                        <td class="p-2 text-green-500">{{ $row['High'] }}</td>
                                        <td class="p-2 text-red-500 border-r border-gray-800">{{ $row['Low'] }}</td>
                                        <td class="p-2">{{ $row['Volume'] }}</td>
                                        <td class="p-2 text-center">{{ $row['Trades'] }}</td>
                                        <td class="p-2 text-center">
                                            <div class="relative w-16 bg-gray-800 rounded h-4 mx-auto overflow-hidden">
                                                <div class="absolute top-0 left-0 h-full bg-green-500" style="width: {{ $row['BuySentiment'] }}%;"></div>
                                                <div class="absolute top-0 left-0 w-full h-full text-[9px] font-bold text-center leading-4 text-white drop-shadow-md">{{ $row['BuySentiment'] }}%</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="15" class="p-8 text-center text-gray-500">Market Data Unavailable - Connect to ML Engine</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Prediction Tool -->
                <div class="col-span-1">
                    <div class="bg-gray-800/80 backdrop-blur-xl overflow-hidden shadow-[0_0_40px_rgba(0,0,0,0.5)] sm:rounded-3xl border border-gray-700/50 relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="p-8 relative z-10">
                            <h3 class="text-2xl font-semibold mb-6 text-white tracking-tight flex items-center gap-3">
                                <div class="p-2 bg-blue-500/20 rounded-lg border border-blue-500/30">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                Run Prediction
                            </h3>
                            
                            <form action="{{ route('predict') }}" method="POST" class="space-y-6">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Stock Symbol (e.g., COMB, DIAL)</label>
                                    <input type="text" name="symbol" class="w-full bg-black/50 border border-gray-600 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Enter Symbol..." required>
                                </div>
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-4 px-6 rounded-xl shadow-[0_10px_25px_rgba(79,70,229,0.4)] hover:shadow-[0_15px_35px_rgba(79,70,229,0.5)] transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 group">
                                    Analyze & Predict
                                    <svg class="w-5 h-5 text-indigo-200 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Hot Zones -->
                <div class="col-span-1 lg:col-span-2">
                    <div class="bg-gray-800/80 backdrop-blur-xl overflow-hidden shadow-[0_0_40px_rgba(0,0,0,0.5)] sm:rounded-3xl border border-gray-700/50">
                        <div class="p-8">
                            <h3 class="text-2xl font-semibold mb-6 text-white tracking-tight flex items-center gap-3">
                                <div class="relative flex items-center justify-center w-10 h-10 rounded-full bg-orange-500/20 border border-orange-500/50">
                                    <svg class="w-6 h-6 text-orange-400 drop-shadow-[0_0_8px_rgba(249,115,22,0.8)] animate-[pulse_2s_ease-in-out_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                                    </svg>
                                </div>
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
