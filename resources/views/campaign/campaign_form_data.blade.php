@csrf
<div class="row s12">
    <div class="input-field col s4">
        <input id="name" type="text" name="name" value="{{ old('name', $campaign->name) }}">
        <label for="name">Nomeda da Campanha</label>
    </div>
    <div class="input-field col s4">
        <input id="starts_at" type="date" name="starts_at" value="{{ old('starts_at', $campaign->starts_at) }}">
        <label for="starts_at">Começa</label>
    </div>
    <div class="input-field col s4">
        <input id="ends_at" type="date" name="ends_at" value="{{ old('ends_at', $campaign->ends_at) }}">
        <label for="ends_at">Termina</label>
    </div>
</div>
<div class="row s12">
    <div class="input-field col s3">
        <input id="suggested_donation" type="text" name="suggested_donation"
               data-inputmask="'mask': '9{1,},9{2}', 'placeholder': ''"
               value="{{ old('suggested_donation', $campaign->suggested_donation) }}">
        <label for="suggested_donation">Valor Sugerido</label>
        <span class="helper-text" >Valor Sugerido para doação</span>
    </div>
    <div class="input-field col s3">
        <input id="target_amount" type="text" name="target_amount"
               data-inputmask="'mask': '9{1,},9{2}', 'placeholder': ''"
               value="{{ old('target_amount', $campaign->target_amount) }}">
        <label for="target_amount">Meta de Valor</label>
        <span class="helper-text" >Meta de arrecadação</span>
    </div>
    <div class="input-field col s6">
        <input id="description" type="text" name="description"
               value="{{ old('description', $campaign->description) }}">
        <label for="description">Descrição</label>
        <span class="helper-text" >Breve descrição</span>
    </div>
</div>
<div class="divider"></div>
<div class="section">
    <div class="row">
        <div class="col s12 right-align">
            <button type="submit" class="btn btnLoading blue darken-1"><i class="material-icons left">save</i>Salvar</button>
        </div>
    </div>
</div>
