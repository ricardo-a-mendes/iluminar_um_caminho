@csrf

<div class="ui form">
    <div class="three fields">
        <div class="required field @if ($errors->has('name')) error @endif">
            <label for="name">Nome da Campanha</label>
            <input id="name" type="text" name="name" value="{{ old('name', $campaign->name) }}">
            @if ($errors->has('name'))<small class="helper">{{ $errors->first('name') }}</small>@endif
        </div>
        <div class="required field @if ($errors->has('ends_at')) error @endif">
            <label for="starts_at">Começa em</label>
            <input id="starts_at" type="date" name="starts_at" value="{{ old('starts_at', $campaign->starts_at) }}">
            @if ($errors->has('starts_at'))<small class="helper">{{ $errors->first('starts_at') }}</small>@endif
        </div>
        <div class="required field @if ($errors->has('name')) error @endif">
            <label for="ends_at">Termina em</label>
            <input id="ends_at" type="date" name="ends_at" value="{{ old('ends_at', $campaign->ends_at) }}">
            @if ($errors->has('ends_at'))<small class="helper">{{ $errors->first('ends_at') }}</small>@endif
        </div>
    </div>

    <div class="three fields">
        <div class="three wide required field @if ($errors->has('suggested_donation')) error @endif">
            <label for="suggested_donation">Valor Sugerido (para doação)</label>
            <div class="ui left icon input">
                <input id="suggested_donation" type="text" name="suggested_donation"
                       data-inputmask="'mask': '9{1,},9{2}', 'placeholder': ''"
                       value="{{ old('suggested_donation', number_format($campaign->suggested_donation, 2, ',', '.')) }}">
                <i class="dollar sign icon"></i>
            </div>
            @if ($errors->has('suggested_donation'))<small class="helper">{{ $errors->first('suggested_donation') }}</small>@endif
        </div>

        <div class="three wide required field @if ($errors->has('target_amount')) error @endif">
            <label for="target_amount">Meta de Valor</label>
            <div class="ui left icon input">
                <input id="target_amount" type="text" name="target_amount"
                       data-inputmask="'mask': '9{1,},9{2}', 'placeholder': ''"
                       value="{{ old('target_amount', number_format($campaign->target_amount, 2, ',', '.')) }}">
                <i class="dollar sign icon"></i>
            </div>
            @if ($errors->has('target_amount'))<small class="helper">{{ $errors->first('target_amount') }}</small>@endif
        </div>

        <div class="ten wide required field @if ($errors->has('description')) error @endif">
            <label for="description">Breve Descrição</label>
            <input id="description" type="text" name="description"
                   value="{{ old('description', $campaign->description) }}">
            @if ($errors->has('description'))<small class="helper">{{ $errors->first('description') }}</small>@endif
        </div>
    </div>
    <div class="ui divider"></div>
    <div class="ui column grid">
        <div class="row">
            <div class="column right aligned">
                <button type="submit" class="ui button btnLoading blue">Salvar <i class="save right aligned icon"></i></button>
            </div>
        </div>

    </div>
</div>


