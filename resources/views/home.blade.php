@extends('layouts.app')

@section('container')

    <div class="ui segments">
        <div class="ui segment">
            <div class="ui grid">
                <div class="four wide column"><img class="ui medium circular image"
                                                   src="{{ asset('images/projeto_iluminar_um_caminho.jpeg') }}"></div>
                <div class="twelve wide column">
                    <h2 class="ui header center aligned">
                        <div class="content">
                            <blockquote>
                                "... não adianta ser luz se eu não for capaz<br>de iluminar o caminho de outras pessoas!"
                            </blockquote>
                        </div>
                    </h2>
                </div>

            </div>
        </div>

        <div class="ui left aligned attached blue segment">
            <div class="ui two column very relaxed left aligned grid">
                <div class="ui vertical divider"></div>

                <div class="column">
                    <h1 class="ui header">
                        <i class="heart outline small icon"></i>
                        <div class="content">
                            Doações
                        </div>
                    </h1>


                    <div class="content">
                        <ul class="left aligned">
                            <li>As doações são recebidas através do Pag Seguro</li>
                            <li>Descontos aplicados sobre a doação (pelo Pag Seguro)
                                <ol>
                                    <li>3,99% sobre o valor total da doação (transação)</li>
                                    <li>R$ 0,40 sobre cada transação</li>
                                </ol>
                            </li>
                            <li>Por Exemplo: Ao doar R$ 100,00 nós recebemos R$ 95,61. São os descontos:
                                <ol>
                                    <li>Desconto de 3,99% = R$ 3.99</li>
                                    <li>Desconto de R$ 0,40</li>
                                </ol>
                            </li>
                            <li>Ao se registrar no site, você terá os seguintes acessos:
                                <ul>
                                    <li>Relatório de doações das campanhas que você participar</li>
                                    <li>Fotos exclusivas da campanha e seus beneficiados</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="column">
                    <h1 class="ui header">
                        <i class="handshake outline icon"></i>
                        <div class="content">
                            Campanhas
                        </div>
                    </h1>

                    <div class="content">
                        <p>
                            Se você participa de algum trabalho voluntário ou está ajudando em alguma campanha de arrecadação, pode solicitar o
                            cadastro da sua campanha através do e-mal: <a href="mailto:projetoiluminarumcaminho@gmail.com">projetoiluminarumcaminho@gmail.com</a>
                        </p>
                        <p>
                            A campanha passará pela avaliação dos membros do projeto e poderá ser publicada no site.
                        </p>
                        <p>
                            O valor líquido arrecadado (descontadas as tarifas) será transferido para uma conta corrente de sua indicação após 30 dias do encerramento da campanha.
                        </p>
                        <p>
                            Para mais informações sobre as campanhas, acesse nossa página de <a href="#">termos e condições</a>.
                        </p>
                        <p>
                            A campanha, assim como nosso projeto, deve ser sem fins lucrativos
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>





@endsection
