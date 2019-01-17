@extends('layouts.app')

@section('container')

    <div class="ui raised segment">
        <p>Essa é a turminha que colocou em prátia um projeto idealizado por um grupo de amigos, que você vai saber quem são logo abaixo.</p>
    </div>

    <div class="ui relaxed grid">
        <div class="ui three column row">

            <div class="column">
                <div class="ui fluid raised card">
                    <div class="image">
                        <img src="{{asset('images/about/diego_nobrega.jpg')}}">
                    </div>
                    <div class="content">
                        <div class="header">Diego Nobrega</div>
                        <div class="meta">"Agir agora"</div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="ui fluid raised card">
                    <div class="image">
                        <img src="{{asset('images/about/mariana_favaro.jpg')}}">
                    </div>
                    <div class="content">
                        <div class="header">Mariana Favaro</div>
                        <div class="meta">"Ser é diferente de estar"</div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="ui fluid raised card">
                    <div class="image">
                        <img src="{{asset('images/about/ricardo_mendes.jpg')}}">
                    </div>
                    <div class="content">
                        <div class="header">Ricardo Mendes</div>
                        <div class="meta">"Você é o que você pensa"</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui stacked segment">
        <p>Tudo começou quando fizemos uma sequência de treinamentos de desenvolvimento pessoal com a equipe da <a
                    href="http://dimensaonet.com.br/new/">Dimensão</a>.
            <br>
            Nestes treinamentos entendemos a importância de ajudar o próximo sem esperar nada de volta, ou seja: doar, iluminar.
            <br>
            Certo momento, nosso grupo de amigos do treinamento idealizou um projeto onde pudessemos iluminar o caminho do próxomo.
            <br>
            Foi então que esses três maluquinhos se uniram para dar vida a esse projeto.
        </p>
        <p>
            Este sistema de arrecadação de doações foi desenvolvido com o objetivo de facilitar a arrecadação e principalmente a prestação de contas
            de cada campanha.
        </p>
        <p>Este é um projeto sem fim lucrativos!</p>
    </div>

@endsection
