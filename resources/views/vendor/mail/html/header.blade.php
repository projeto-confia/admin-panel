<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<x-common.logo class="py-0 mx-1" />
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
