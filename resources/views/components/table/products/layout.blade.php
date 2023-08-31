@props(['lang_file', 'products'])
<div class="d-flex justify-content-center tab-pane">
    <div class="overflow-hidden table-responsive m-3" style="width: min(100%, 75em)">
        <table id="lend_products_table" class="table table-hover table-striped dt-responsive ml-lg-5 mr-lg-5 lend_products_table" style="width: 100%">
            <thead>
                <tr>
                    <th hidden scope="col">ID</th>
                    <th scope="col">{{ __($lang_file . 'name') }}</th>
                    <th scope="col" hidden></th>
                    <th class="d-none d-sm-table-cell" scope="col">{{ __($lang_file . 'currently_loaned') }}</th>
                    <th class="d-none d-md-table-cell" scope="col"></th>
                    <th class="d-none d-md-table-cell" scope="col">{{ __($lang_file . 'total_stock') }}</th>
                    <th class="d-none d-lg-table-cell" scope="col"></th>
                    <th class="d-none d-lg-table-cell" scope="col">
                        {{ __($lang_file . 'currently_loaned_percentage') }}</th>
                    <th class="d-none d-lg-table-cell">{{ __($lang_file . 'featured') }}</th>
                    <th class="d-none d-lg-table-cell"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    @php
                        $percentage_outstanding = null;
                        if ($product->stock != null && $product->stock != 0) {
                            $percentage_outstanding = round(($product->outstanding / $product->stock) * 100);
                        }
                        $outstanding_state = '';
                        if ($percentage_outstanding > 80) {
                            $outstanding_state = 'text-danger';
                        } elseif ($percentage_outstanding > 60) {
                            $outstanding_state = 'text-warning';
                        }
                    @endphp
                    <tr class="{{ $product->archived ? 'text-muted' : '' }}">
                        <td>
                            {{ $product->id }}
                        </td>
                        <td style="width: 30%">
                            <a class="text-dark" style="text-decoration: none;"
                                href="{{ route('product_details', ['product' => $product]) }}">
                                {{ $product->name }}
                                @if ($product->is_secured)
                                    <i class="bi bi-lock"></i>
                                @elseif ($product->no_loan_registration)
                                    <i class="bi bi-clipboard-x"></i>
                                @endif
                            </a>
                        </td>
                        <td hidden>{{ $product->archived != null ? 'Ja' : 'Nee' }}</td>
                        @if($product->no_loan_registration)
                            <td class="d-none d-sm-table-cell" aria-hidden="true"></td>
                            <td class="d-none d-md-table-cell" aria-hidden="true"></td>
                            <td class="d-none d-md-table-cell">
                                @if ($product->stock != null)
                                    {{ $product->stock }}
                                @else
                                    <span style="color: rgba(0, 0, 0, 0.3)">{{ __($lang_file . 'no_stock') }}</span>
                                @endif
                            </td>
                            <td class="d-none d-lg-table-cell" aria-hidden="true"></td>
                            <td class="d-none d-lg-table-cell" aria-hidden="true"></td>
                        @else
                            <td class="d-none d-sm-table-cell"
                                class="{{ $product->totalOverDueAmount() > 0 ? 'text-danger' : '' }}">
                                {{ $product->outstanding }}
                            </td>
                            <td class="d-none d-md-table-cell" aria-hidden="true">
                                <span style="color: rgba(0, 0, 0, 0.3)">÷</span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                @if ($product->stock != null)
                                    {{ $product->stock }}
                                @else
                                    <span style="color: rgba(0, 0, 0, 0.3)">{{ __($lang_file . 'no_stock') }}</span>
                                @endif
                            </td>
                            <td class="d-none d-lg-table-cell" aria-hidden="true">
                                <span style="color: rgba(0, 0, 0, 0.3)">=</span>
                            </td>
                            <td class="{{ $outstanding_state }} d-none d-lg-table-cell">
                                @if ($percentage_outstanding != null)
                                    {{ $percentage_outstanding . '%' }}
                                @else
                                    <span
                                        style="color: rgba(0, 0, 0, 0.3)">{{ __($lang_file . 'currently_loaned_percentage_empty_message') }}</span>
                                @endif
                            </td>
                        @endif
                        <td class="d-none d-lg-table-cell" style="width: 15%">
                            @php($position = $product->featuredPosition())
                            @if ($position)
                                <span class="m-0"> {{ __($lang_file . 'position') }}
                                    {{ $product->featuredPosition() }}</span>
                            @endif
                        </td>

                        <td class="d-none d-lg-table-cell" aria-hidden="true" style="width: 10%">
                            <a aria-label="open details van {{ $product->name }}"
                                href="{{ route('product_details', ['product' => $product]) }}"
                                class="btn {{ $product->archived ? 'btn-secondary' : 'btn-dark' }}">
                                {{ __($lang_file . 'details') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
