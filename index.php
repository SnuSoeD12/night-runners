<?php
require_once "db.php";
date_default_timezone_set("Asia/Krasnoyarsk");

if (isset($_POST["send"])) {
    $name = trim($_POST["name"]);
    $rating = (int)$_POST["rating"];
    $review = trim($_POST["review"]);

    if ($name != "" && $review != "") {

        $name = mysqli_real_escape_string($connection, $name);
        $review = mysqli_real_escape_string($connection, $review);

        $sql = "INSERT INTO reviews (name, rating, review_text, created_at)
                VALUES ('$name', $rating, '$review', NOW())";

        mysqli_query($connection, $sql);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIGHT-RUNNERS Fan Base</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/logo.svg" type="image/svg+xml">
</head>
<body>
    <header>
        <div class="logo">NIGHT-RUNNERS <span>FAN BASE</span></div>
        <nav>
            <a class="active" href="index.php">Главная</a>
            <a href="about.html">Об игре</a>
            <a href="gameplay.html">История</a>
            <a href="tuning.html">Тюнинг</a>
            <a href="gallery.html">Галерея</a>
			<a href="music.html">Музыка</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-text">
                <p class="small-title">ФАН-САЙТ ПО ИГРЕ</p>
                <h1>NIGHT-RUNNERS<br>PROLOGUE</h1>
                <p>
                    Ночные улицы Японии, уличные гонки, ставки и большое количество
                    деталей для автомобиля. Здесь собрана основная информация об игре.
                </p>
                <a class="button" href="about.html">Узнать об игре</a>
            </div>
            <img src="images/header.jpg" alt="NIGHT-RUNNERS PROLOGUE">
		</section>
			
        <section class="content-block">
            <div class="cards">
                <article class="card">
                    <h3>Нелегальные уличные гонки</h3>
                    <p>Заезды один на один проходят ночью. Перед гонкой можно договориться о ставке с соперником.</p>
                </article>
                <article class="card">
                    <h3>Тюнинг</h3>
                    <p>Можно менять внешний вид, колёса, увеличивать мощность двигателя, салон и элементы, влияющие на управление.</p>
                </article>
                <article class="card">
                    <h3>Атмосфера</h3>
                    <p>Парковки, гаражи, тёмные трассы, трафик, визуальный стиль японской автомобильной культуры. Где весь геймплей сопровождается эффектом VHS камеры </p>
                </article>
            </div>
        </section>

        <section class="two-columns">
            <img src="images/scene1.jpg" alt="Автомобиль на ночной улице">
            <div>
                <h2>О проекте</h2>
                <p>
                    Этот сайт является небольшой фан-базой по игре NIGHT-RUNNERS: PROLOGUE.
                    На страницах можно прочитать об основных механиках, тюнинге и посмотреть изображения из игры.
                </p>
                <p>
                    NIGHT-RUNNERS: PROLOGUE выпущена студией PLANET JEM 23 февраля 2024 года.
					Игра распространяется бесплатно в  
					<a href="https://store.steampowered.com/app/2707900/NIGHTRUNNERS_PROLOGUE/" target="_blank">Steam</a>.
			</p>
            </div>
        </section>

	<section class="reviews">
		<h2>Отзывы об игре</h2>

		<p>
			Оставьте свое мнение о NIGHT-RUNNERS: PROLOGUE.
		</p>

		<form method="post" action="index.php">
			<label for="name">Имя:</label>
			<input type="text" id="name" name="name" required>

			<label for="rating">Оценка:</label>
			<select id="rating" name="rating">
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
			</select>

			<label for="review">Отзыв:</label>
			<textarea id="review" name="review" required></textarea>

			<button type="submit" name="send">Оставить отзыв</button>
		</form>


		<h2>Отзывы пользователей</h2>

<?php
$limit = 3;
$page = 1;
if (isset($_GET["page"])) 
{
    $page = (int)$_GET["page"];
}
if ($page < 1)
{
    $page = 1;
}

//считаем для пропуска отзывов
$offset = ($page - 1) * $limit;

//посчет кол-ва отзывов
$count_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM reviews");
$count_data = mysqli_fetch_assoc($count_result);
$total_reviews = $count_data["total"];
$total_pages = ceil($total_reviews / $limit);

// получение отзывов из БД
$sql = "SELECT * FROM reviews
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset";

$result = mysqli_query($connection, $sql);

while ($row = mysqli_fetch_assoc($result)) //вывод отзывов
{
    echo '<div class="review">';

    echo '<h3>' .
        htmlspecialchars($row["name"]) .
        '</h3>';
    echo '<p class="review-rating">Оценка: ' .
        htmlspecialchars($row["rating"]) .
        '/5</p>';
	echo '<p>' .
		nl2br(htmlspecialchars($row["review_text"])) .
		'</p>';
    echo '<p class="review-date">' .
        htmlspecialchars($row["created_at"]) .
        '</p>';

    echo '</div>';
}

if ($total_pages > 1) //номера страниц
{
    echo '<div class="pagination">';
    for ($i = 1; $i <= $total_pages; $i++) 
    {
        if ($i == $page) 
        {
            echo '<span class="current-page">' . $i . '</span>';
        } 
        else 
        {
            echo '<a href="index.php?page=' . $i . '">' . $i . '</a>';
        }
    }

    echo '</div>';
}
?>
	</section>
    </main>

    <footer>
        <p>NIGHT-RUNNERS Fan Base, 2026</p>
        <p>Неофициальный фан-сайт</p>
    </footer>
</body>
</html>
