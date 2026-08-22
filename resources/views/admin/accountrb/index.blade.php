@extends('layouts.admin')
@section('title', 'Nick Robux')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Nick Robux</h1>
        <p class="mt-1 text-sm text-muted-foreground">{{ $accounts->total() }} tài khoản trong kho</p>
    </div>
    <a href="{{ route('admin.accountrb.create') }}" class="btn-primary">Thêm nick</a>
</div>

<div class="card mb-6">
    <form method="GET" action="{{ route('admin.accountrb.index') }}"
          class="card-body grid grid-cols-1 gap-4 md:grid-cols-4">

        <div class="md:col-span-2">
            <label for="keyword" class="label mb-2 block">Tìm theo người mua</label>
            <input id="keyword" name="keyword" type="search"
                   value="{{ request()->query('keyword') }}" class="input"
                   placeholder="Email khách hàng">
        </div>

        <div>
            <label for="status" class="label mb-2 block">Trạng thái</label>
            {{-- Giá trị status được so khớp dưới dạng binding ở
                 controller, không ghép chuỗi vào SQL. --}}
            <select id="status" name="status" class="input">
                <option value="">Tất cả</option>
                <option value="1" @selected(request()->query('status') === '1')>Đang bán</option>
                <option value="2" @selected(request()->query('status') === '2')>Đã bán</option>
                <option value="3" @selected(request()->query('status') === '3')>Bảo hành</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary">Lọc</button>
            <a href="{{ route('admin.accountrb.index') }}" class="btn-outline">Xoá lọc</a>
        </div>
    </form>
</div>

@if ($accounts->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">Kho đang trống.</div>
    </div>
@else
    @php
        $toggle = fn (string $col) => request()->fullUrlWithQuery([
            'sort' => $col,
            'dir'  => ($column === $col && $direction === 'asc') ? 'desc' : 'asc',
        ]);
    @endphp

    <div class="card overflow-hidden">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th><a href="{{ $toggle('id') }}" class="hover:text-primary">ID</a></th>
                        <th class="text-right">
                            <a href="{{ $toggle('robux') }}" class="hover:text-primary">Robux</a>
                        </th>
                        <th><a href="{{ $toggle('rate') }}" class="hover:text-primary">Rate</a></th>
                        <th class="text-right">
                            <a href="{{ $toggle('price') }}" class="hover:text-primary">Giá</a>
                        </th>
                        <th>Premium</th>
                        <th>Bảo hành</th>
                        <th>Người mua</th>
                        <th>Trạng thái</th>
                        <th class="text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $account)
                        <tr>
                            <td class="text-muted-foreground">#{{ $account->id }}</td>
                            <td class="text-right">
                                {{ number_format((int) $account->robux, 0, ',', '.') }}
                            </td>
                            <td>{{ $account->rate }}</td>
                            <td class="text-right whitespace-nowrap font-semibold text-primary">
                                {{ number_format((int) $account->price, 0, ',', '.') }}đ
                            </td>
                            <td>
                                @if ((string) $account->premium === '1')
                                    <span class="badge-success">Có</span>
                                @else
                                    <span class="badge-secondary">Không</span>
                                @endif
                            </td>
                            <td>{{ $account->guarantee ?: '—' }}</td>
                            <td class="break-all">{{ $account->username ?: '—' }}</td>
                            <td>
                                @if ($account->status === \App\Models\AccountRb::STATUS_ON_SALE)
                                    <span class="badge-success">Đang bán</span>
                                @elseif ($account->status === \App\Models\AccountRb::STATUS_SOLD)
                                    <span class="badge-secondary">Đã bán</span>
                                @else
                                    <span class="badge-warning">Bảo hành</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.accountrb.edit', $account) }}"
                                       class="btn-outline btn-sm">Sửa</a>

                                    {{-- Chỉ nick đang bán mới cho xoá; server
                                         kiểm tra lại điều kiện này nên ẩn nút
                                         chỉ là tiện lợi, không phải bảo vệ. --}}
                                    @if ($account->status === \App\Models\AccountRb::STATUS_ON_SALE)
                                        <form method="POST"
                                              action="{{ route('admin.accountrb.destroy', $account) }}"
                                              onsubmit="return confirm('Xoá nick #{{ $account->id }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-destructive btn-sm">Xoá</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $accounts->links() }}</div>
@endif
@endsection
