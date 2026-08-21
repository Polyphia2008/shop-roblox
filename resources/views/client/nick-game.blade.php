@extends('layouts.app')
@section('title', 'Nick game')

@section('content')
<div class="card mb-6">
    <div class="card-body">
        {{-- Tìm kiếm + sắp xếp bằng GET. Giá trị sortBy được ép qua
             allow-list ở HomeController nên không thể inject ORDER BY. --}}
        <form method="GET" action="{{ route('nick-game') }}"
              class="grid grid-cols-1 gap-4 md:grid-cols-3">

            <div>
                <label for="keyword" class="mb-2 block text-sm font-medium">Tìm kiếm</label>
                <input id="keyword" name="keyword" type="search" value="{{ $keyword }}"
                       class="input" placeholder="Nhập tên nick...">
            </div>

            <div>
                <label for="sortBy" class="mb-2 block text-sm font-medium">Sắp xếp theo</label>
                <select id="sortBy" name="sortBy" class="input">
                    <option value="" @selected($sortBy === '')>Mới nhất</option>
                    <option value="price-low" @selected($sortBy === 'price-low')>Giá từ thấp đến cao</option>
                    <option value="price-high" @selected($sortBy === 'price-high')>Giá từ cao đến thấp</option>
                    <option value="robux-high" @selected($sortBy === 'robux-high')>Robux nhiều nhất</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="btn-primary">Tìm kiếm</button>
                <a href="{{ route('nick-game') }}" class="btn-outline">Xoá lọc</a>
            </div>
        </form>
    </div>
</div>

<div class="mb-4 flex items-center justify-between">
    <h1 class="text-lg font-semibold">Kho nick game</h1>
    <span class="text-sm text-muted-foreground">{{ $nicks->total() }} nick</span>
</div>

@if ($nicks->isEmpty())
    <div class="card"><div class="card-body text-center text-muted-foreground">
        Không tìm thấy nick nào phù hợp.
    </div></div>
@else
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên nick</th>
                        <th>Chuyên mục</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nicks as $nick)
                        <tr>
                            <td class="text-muted-foreground">#{{ $nick->id }}</td>
                            <td class="font-medium">{{ $nick->code }}</td>
                            <td>{{ $nick->chuyenmuc }}</td>
                            <td class="text-muted-foreground">{{ Str::limit($nick->note, 40) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $nicks->links() }}</div>
@endif

@if ($categories->isNotEmpty())
    <h2 class="mb-4 mt-10 text-lg font-semibold">Mua theo chuyên mục</h2>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($categories as $category)
            <a href="{{ route('category', $category->code) }}" class="card transition hover:border-primary">
                <div class="card-body space-y-1">
                    <h3 class="font-medium">{{ $category->title }}</h3>
                    <p class="font-semibold text-primary">{{ number_format((int) $category->price, 0, ',', '.') }}đ</p>
                </div>
            </a>
        @endforeach
    </div>
@endif
@endsection
