@props(['categories', 'sort_columns', 'order', 'sort', 'title' => 'Producten'])


<form class="mb-3 text-center" action="#" method="GET">
    <x-interactive.product-search />
    <p class="h4 mt-3 fw-bolder">{{ $title }}</p>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        {{ __('loaner.filter_and_sort.title') }}
                    </h1>
                    <i class="d-inline bi bi-sliders" data-bs-dismiss="modal" style="scale: 1.5"></i>
                </div>
                <div class="modal-body pt-0">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item border-start-0 border-end-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    {{ __('loaner.filter_and_sort.categories') }}
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="d-flex flex-column text-left">
                                        @php
                                            $categories_keys = array_map(fn($value) => $value['id'], $categories->toArray());
                                            $categories_values = array_map(fn($value) => $value['name'], $categories->toArray());
                                            $categories = array_combine($categories_keys, $categories_values);
                                        @endphp
                                        <x-form.accordion_select :options="$categories" :subject="'category'" :selected_key="request('category')"
                                            :default-key="null"></x-form.accordion_select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-start-0 border-end-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    {{ __('loaner.filter_and_sort.sort') }}
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="d-flex flex-column text-left">
                                        <x-form.accordion_select :options="$sort_columns" :subject="'sort'" :selected_key="$sort"
                                            :default_key="'name'"></x-form.accordion_select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-start-0 border-end-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ __('loaner.filter_and_sort.order') }}
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="d-flex flex-column text-left">
                                        <x-form.accordion_select :options="[
                                            'asc' => __('loaner.filter_and_sort.asc'),
                                            'desc' => __('loaner.filter_and_sort.desc'),
                                        ]" :subject="'order'" :selected_key="$order"
                                            :default_key="'asc'"></x-form.accordion_select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button id="reset-filters-button" class="btn mt-2 fst-italic text-primary">
                                {{ __('loaner.filter_and_sort.reset') }}
                            </button>
                        </div>
                        <script>
                            const reset_filters_button = document.getElementById('reset-filters-button');

                            function resetFilters() {
                                const inputs = document.getElementsByClassName('accordion-select-input');
                                for (let input of inputs) {
                                    const default_key_value = input.dataset.defaultkey;
                                    const default_key = default_key_value === 'true';
                                    input.removeAttribute('checked');
                                    if (default_key) {
                                        input.setAttribute('checked', '');
                                    }
                                }
                                this.form.submit();
                            }

                            reset_filters_button.onclick = ev => resetFilters();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
