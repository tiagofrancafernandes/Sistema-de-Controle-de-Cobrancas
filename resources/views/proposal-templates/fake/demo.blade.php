<div>
    <h5>Proposal</h5>
    <h6>Expires in {{ $cdata('expires_in') }}</h6>
    <h6>Expires in {{ $cdata('expiresIn') }}</h6>
    <h6>Expires in {{ $cdata('expires In') }}</h6>
    <div>{{ json_encode($cdata(), 64) }}</div>

    <div>
        <h6>Item 1</h6>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate porro cum, fuga repellendus in provident.</p>

        <h6>Item 2</h6>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate porro cum, fuga repellendus in provident.</p>

        <h6>Item 3</h6>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate porro cum, fuga repellendus in provident.</p>

        <h6>Item 4</h6>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate porro cum, fuga repellendus in provident.</p>
    </div>

    @if ($cdata?->items ?? [])
        <table>
            <tr>
                <th>#</th>
                <th>@lang('proposal.item.title')</th>
                <th>@lang('proposal.item.inline_note')</th>
                <th>@lang('proposal.item.quantity')</th>
                <th>@lang('proposal.item.price')</th>
                <th>@lang('proposal.item.amount_sum')</th>
                <th>@lang('proposal.item.discount_pre_paid')</th>
                <th>@lang('proposal.item.discount_after')</th>
                <th>@lang('proposal.item.pre_paid_amount_sum')</th>
                <th>@lang('proposal.item.after_amount_sum')</th>
            </tr>
            @foreach ($cdata?->items ?? [] as $item)
            <li>{{ $item?->title }}</li>
            @endforeach
        </table>
    @endif
</div>
