<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Include your CSS or assets here -->
</head>
<body>
    @include('navbar')

    <section class="antialiased text-gray-600 px-4">
        <div class="flex flex-col justify-center h-full mt-10">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-800">Articles</h2>
                </header>
                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">
                                        <a href="?sortBy=name&direction={{ request('direction') === 'desc' ? 'asc' : 'desc' }}">
                                            Nom
                                        </a>
                                    </div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">
                                        <a href="?sortBy=status&direction={{ request('direction') === 'desc' ? 'asc' : 'desc' }}">
                                            Statut
                                        </a>
                                    </div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">
                                        Catégorie
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                            @foreach($products as $product)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="font-medium text-gray-800">
                                                {{ $product->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-left">
                                            <span class="bg-{{ $product->status === 'available' ? 'green' : ($product->status === 'unavailable' ? 'red' : 'gray') }}-100 text-{{ $product->status === 'available' ? 'green' : ($product->status === 'unavailable' ? 'red' : 'gray') }}-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-{{ $product->status === 'available' ? 'green' : ($product->status === 'unavailable' ? 'red' : 'gray') }}-900 dark:text-{{ $product->status === 'available' ? 'green' : ($product->status === 'unavailable' ? 'red' : 'gray') }}-300">{{ ucfirst($product->status) }}</span>
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-left font-medium text-gray-600">{{ $product->category->name }}</div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $products->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
