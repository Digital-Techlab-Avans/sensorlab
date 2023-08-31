@props(['name' => 'datetime', 'placeholder' => 'dd-mm-yyyy hh:mm', 'value' => null, 'input_id' => 'datetimepicker', 'button_id' => 'datetimepicker_button', 'button_icon' => 'bi-calendar-event'])

<label class="d-flex w-100">
    @php($date_picker_value = date('d-m-Y H:i', strtotime(old($name) ?? $value ?? '')))
    <input id="{{$input_id}}" type="text" name="{{$name}}" placeholder="{{$placeholder}}"
           class="form-control-plaintext rounded-1 border-1 border-dark flex-grow-1 p-1"
           value="{{ $date_picker_value ?? ''}}"/>
    <button type="button" class="btn btn-outline-dark m-1 mt-0 mb-0" id="{{$button_id}}">
        <i class="bi {{$button_icon}}"></i>
    </button>
</label>

<script>
    flatpickr('#{{$input_id}}', {
        enableTime: true,
        dateFormat: "d-m-Y H:i",
        time_24hr: true,
        minDate: "today",
        minuteIncrement: 15,
        locale: {
            firstDayOfWeek: 1
        }
    });

    //focus the input on button click
    document.getElementById('{{$button_id}}').addEventListener('click', function () {
        document.getElementById('{{$input_id}}').focus();
    });
</script>
