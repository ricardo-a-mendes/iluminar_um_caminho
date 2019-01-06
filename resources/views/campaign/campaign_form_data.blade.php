@csrf

<div class="ui form">
    <div class="three fields">
        <div class="required field">
            <label for="name">Nome da Campanha</label>
            <input id="name" type="text" name="name" value="{{ old('name', $campaign->name) }}">
        </div>
        <div class="required field">
            <label for="starts_at">Começa em</label>
            <input id="starts_at" type="date" name="starts_at" value="{{ old('starts_at', $campaign->starts_at) }}">
        </div>
        <div class="required field">
            <label for="ends_at">Termina em</label>
            <input id="ends_at" type="date" name="ends_at" value="{{ old('ends_at', $campaign->ends_at) }}">
        </div>
    </div>

    <div class="three fields">
        <div class="three wide required field">
            <label for="suggested_donation">Valor Sugerido</label>
            <div class="ui left icon input">
                <input id="suggested_donation" type="text" name="suggested_donation"
                       data-inputmask="'mask': '9{1,},9{2}', 'placeholder': ''"
                       value="{{ old('suggested_donation', number_format($campaign->suggested_donation, 2, ',', '.')) }}">
                <i class="dollar sign icon"></i>
            </div>
        </div>

        <div class="three wide required field">
            <label for="target_amount">Meta de Valor</label>
            <div class="ui left icon input">
                <input id="target_amount" type="text" name="target_amount"
                       data-inputmask="'mask': '9{1,},9{2}', 'placeholder': ''"
                       value="{{ old('target_amount', number_format($campaign->target_amount, 2, ',', '.')) }}">
                <i class="dollar sign icon"></i>
            </div>
        </div>

        <div class="ten wide required field">
            <label for="description">Breve Descrição</label>
            <input id="description" type="text" name="description"
                   value="{{ old('description', $campaign->description) }}">
        </div>
    </div>
    <div class="ui column grid">
        <div class="row">
            <div class="column right aligned">
                <button type="submit" class="ui button btnLoading blue">Salvar <i class="save right aligned icon"></i></button>
            </div>
        </div>

    </div>
</div>


