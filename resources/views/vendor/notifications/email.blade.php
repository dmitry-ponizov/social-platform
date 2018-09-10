@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# @lang('Whoops!')
@else
# @lang('Доброго дня!')
@endif
@endif

{{-- Intro Lines --}}
@lang('Ви отримали цей електронний лист, оскільки ми отримали запит на скидання пароля для вашого облікового запису.')

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
@lang('Скинути пароль')
@endcomponent
@endisset

{{-- Outro Lines --}}
@lang('Якщо ви не надіслали запит на скидання пароля, подальші дії не потрібні.')
{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
    <br>
@lang('З повагою Dobro.ua')
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang(
    "Якщо у вас виникають проблеми, натиснувши кнопку «Скидання пароля», скопіюйте та вставте URL нижче ".
    'у ваш браузер: [:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl
    ]
)
@endcomponent
@endisset
@endcomponent
