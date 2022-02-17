<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/ic_dexters.png">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/integrantes.css">
    <title>DEXTERS | Integrantes</title>
</head>
<body>
    <?php include('cabecalho.html'); ?>
    
    <main>
        <h2 class="titulo">INTEGRANTES</h2>
        <section id="integrantes">

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
                <button onclick="toggleModal()" class="btn-default btn-detalhes">Detalhes</button>
            </div>

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
                <button onclick="toggleModal()" class="btn-default btn-detalhes">Detalhes</button>
            </div>

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
                <button onclick="toggleModal()" class="btn-default btn-detalhes">Detalhes</button>
            </div>

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
                <button onclick="toggleModal()" class="btn-default btn-detalhes">Detalhes</button>
            </div>

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
                <button onclick="toggleModal()" class="btn-default btn-detalhes">Detalhes</button>
            </div>

        </section>
        <h2 class="titulo">EX-INTEGRANTES</h2>
        <section id="ex-integrantes">

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
            </div>

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
            </div>

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
            </div>

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
            </div>

            <div class="card-integrante">
                <div class="imagem"></div>
                <h4>Nome Sobrenome</h4>
            </div>

        </section>
    </main>
    
    <?php include('rodape.html'); ?>

    <!-- MODAL -->
    <div id="modal-integrantes" class="modal-background">
        <div class="modal">
            <button onclick="toggleModal()" class="btn-fechar">x</button>
            <div id="infos">
                <p>
                    <span class="info">Nome:</span>
                    <span>Pedro Rocha Boucinhas Pacheco</span>
                </p>
                <p>
                    <span class="info">Cargo:</span>
                    <span>Estudante</span>
                </p>
                <p>
                    <span class="info">Lattes:</span>
                    <span><a>lattes.cnpq.br/6144884845294658</a></span>
                </p>
                <p>
                    <span class="info">Contato:</span>
                    <span>pedro.pacheco@discente.ufma.br</span>
                </p>
            </div> 
        </div>
    </div>

    <script src="js/integrantes.js"></script>
</body>
</html>