<?php
require_once('script/conexao.php');

//Verifica existência da variável 'pagina_atual'
if (!empty($_GET['pagina_atual'])) {
    $current_page = $_GET['pagina_atual'];
} else {
    $current_page = 1;
}

//Definição da URL para paginação dos resultados da busca
if (!empty($_GET['titulo']) || !empty($_GET['autores']) || !empty($_GET['palavra-chave']) || !empty($_GET['ano'])) $url = "titulo={$_GET['titulo']}&autores={$_GET['autores']}&palavra-chave={$_GET['palavra-chave']}&ano={$_GET['ano']}&";
else $url = '';

//Número de itens por página
$items_per_page = 10;

//Índice do item inicial de cada página
$start_item = $items_per_page * ($current_page - 1);

//Obtendo valores dos inputs através do GET
if (!empty($_GET['titulo']) || !empty($_GET['autores']) || !empty($_GET['palavra-chave']) || !empty($_GET['ano'])) {
    $titulo = '%' . $_GET['titulo'] . '%';
    $autores = '%' . $_GET['autores'] . '%';
    $palavra_chave = '%' . $_GET['palavra-chave'] . '%';
    
    if(empty($_GET['ano'])){
        $ano = '%%';
    }else{
        $ano = $_GET['ano'];
    }
    
} else {
    $titulo = $autores = $palavra_chave = $ano = '%%';
}

//Obtendo a quantidade total de linhas que é retornada com base nos parâmetros passados
$instruction = "
SELECT * FROM `tb_publicacoes` WHERE (`titulo` LIKE :titulo) 
                                AND (`autores` LIKE :autores) 
                                AND (`palavra-chave` LIKE :palavra_chave)
                                AND (`ano` LIKE :ano) 
";

$statement = $database->prepare($instruction);
$statement->bindValue(':titulo', $titulo);
$statement->bindValue(':autores', $autores);
$statement->bindValue(':palavra_chave', $palavra_chave);
$statement->bindValue(':ano', $ano);
$statement->execute();

//Número total de linhas
$total_rows = $statement->rowCount();

//Obtendo a quantidade de linhas limitadas por página com base nos parâmetros passados
$instruction = "
SELECT * FROM `tb_publicacoes` WHERE (`titulo` LIKE :titulo) 
                                AND (`autores` LIKE :autores)
                                AND (`palavra-chave` LIKE :palavra_chave)
                                AND (`ano` LIKE :ano)
                                ORDER BY `titulo` ASC
                                LIMIT $start_item, $items_per_page;
";

$statement = $database->prepare($instruction);
$statement->bindValue(':titulo', $titulo);
$statement->bindValue(':autores', $autores);
$statement->bindValue(':palavra_chave', $palavra_chave);
$statement->bindValue(':ano', $ano);
$statement->execute();

//Itens por página
$items = $statement->fetchAll(PDO::FETCH_ASSOC);

//Linhas por página
$rows_per_page = $statement->rowCount();

//Quantidade de páginas necessárias para mostrar os itens
$pages = ceil($total_rows / $items_per_page);

//Caso não houver nenhum resultado para a pesquisa o número de páginas será 0
if ($pages == 0) $current_page = 0;

//Caso 'current_page' contiver um valor inválido o usuário será redirecionado para a última página válida
if ($current_page > $pages) header("Location: publicacoes.php?$url pagina_atual=$pages");

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/ic_dexters.png">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/publicacoes.css">
    <title>Publicações | DEXTERS</title>
</head>

<body>
    <?php include('cabecalho.html'); ?>

    <main>
        <h2 class="titulo">TRABALHOS PUBLICADOS</h2>
        <section id="buscar">
            <form class="form-default" method="get" action="publicacoes.php">
                <label for="titulo">Título</label>
                <input id="titulo" class="text-box-default" name="titulo" type="search" placeholder="Digite o título da publicação" value="<?= (!empty($_GET['titulo'])) ? $_GET['titulo'] : '' ?>">
                <label for="autor">Autor(es)</label>
                <input id="autor" class="text-box-default" name="autores" type="text" placeholder="Digite o nome de um ou mais autores" value="<?= (!empty($_GET['autores'])) ? $_GET['autores'] : '' ?>">
                <label for="palavra-chave">Palavra-chave</label>
                <input id="palavra-chave" class="text-box-default" name="palavra-chave" type="text" placeholder="Digite uma ou mais chaves" value="<?= (!empty($_GET['palavra-chave'])) ? $_GET['palavra-chave'] : '' ?>">
                <label for="ano-publicacao">Ano de publicação</label>
                <input id="ano-publicacao" class="text-box-default" name="ano" type="number" placeholder="Digite o ano da publicação" value="<?= (!empty($_GET['ano'])) ? $_GET['ano'] : '' ?>">

                <button name="buscar" id="buscar" class="btn-default">
                    <img src="images/bt_lupa.png" alt="Botão buscar">
                </button>

            </form>
        </section>
        <hr id="breakpoint">
        <section id="publicacoes" tabindex="-1">
            <?php
            if ($current_page == 0) {
            ?>
                <h1 class="no-results">Não foram encontrados resultados para a consulta.</h1>
                <?php
            } else {
                foreach ($items as $key => $value) {
                    if (strlen($value['resumo']) == 0) {
                        $value['resumo'] = 'Resumo indisponível.';
                    }
                ?>
                    <div class="card-default">
                        <h4>
                            <?= $value['titulo']; ?>
                        </h4>

                        <div class="infos">
                            <div class="descricao">
                                <?php
                                if (strlen($value['resumo']) > 250) {
                                    $resumo = substr($value['resumo'], 0, 250) . '[...]';
                                ?>  
                                    <p><?= $resumo ?> <span id="ver-mais" onclick="openModal(`<?= $value['resumo'] ?>`)">(Ver mais)</span></p>
                                <?php
                                } else {
                                ?>
                                    <p><?= $value['resumo'] ?></p>
                                <?php
                                } //ENDELSE
                                ?>
                            </div>
                            <div class="compartilhar">
                                <p>Compartilhe</p>
                                <div class="redes-sociais">
                                    <img src="images/svg/ic_whatsapp.svg" alt="Whatsapp ícone">
                                    <img src="images/svg/ic_facebook.svg" alt="Facebook ícone">
                                    <img src="images/svg/ic_twitter_blue.svg" alt="Twitter ícone">
                                </div>
                            </div>
                            <div class="autores">
                                <p>
                                    <?= $value['autores']; ?>
                                </p>
                            </div>
                        </div>

                        <div class="download-ano">
                            <a href="<?= $value['link'] ?>" target="_blank">
                                <button class="btn-default">Acesse</button>
                            </a>

                            <p class="ano-publicacao">Ano de publicação: <?= $value['ano'] == '0000' ? 'Indisponível' : $value['ano'] ?></p>
                        </div>
                    </div>
                <?php
                } //ENDFOREACH
                ?>

                <!-- PAINEL DE PAGINAÇÃO -->
                <nav class="paginacao">
                    <ul>
                        <li>
                            <a href="publicacoes.php?<?= $url ?>pagina_atual=1">
                                Primeira
                            </a>
                        </li>

                        <?php
                        $right_margin = $left_margin = 3;
                        for ($page = $current_page - $left_margin; $page <= $current_page + $right_margin; $page++) {
                            if ($current_page == $page) $bt_class = 'active';
                            else $bt_class = '';

                            if ($page >= 1 && $page <= $pages) {
                        ?>
                                <li>
                                    <a class="<?= $bt_class ?>" href="publicacoes.php?<?= $url ?>pagina_atual=<?= $page ?>">
                                        <?= $page ?>
                                    </a>
                                </li>
                        <?php
                            } //ENDIF
                        } //ENDFOR
                        ?>

                        <li>
                            <a href="publicacoes.php?<?= $url ?>pagina_atual=<?= $pages ?>">
                                Última
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php
            } //ENDIFELSE
            ?>
        </section>
    </main>

    <?php include('rodape.html'); ?>

    <!-- MODAL -->
    <div id="modal-publicacoes" class="modal-background">
        <div class="modal">
            <button class="btn-fechar">x</button>
            <div id="infos">
                <p id="descricao"></p>
            </div>
        </div>
    </div>

    <!-- RETORNAR AO TOPO -->
    <div onclick="returnToTop()" id="btn-return-to-top">
        <i class="fa fa-angle-up"></i>
    </div>

    <script src="js/script.js"></script>
    <script src="js/publicacoes.js"></script>
</body>

</html>