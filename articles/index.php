<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fun Olympic 2024 Admin</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            
        }
        /* Styles for the News section */
         #news {
            padding: 40px;
            background-color: #1e1e1e;
            text-align: center;
        }

        #news h2 {
            color: #ffdd40;
            margin-bottom: 20px;
        }

        #news p {
            font-size: 18px;
            line-height: 1.6;
        }

        #news .news-article {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        #news .article {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: left;
        }

        #news .article img {
            width: 100%;
            transition: transform 0.3s ease;
        }

        #news .article:hover img {
            transform: scale(1.1);
        }

        #news .article-text {
            padding: 20px;
        }

        #news .article-text h3 {
            color: #ffdd40;
            margin-top: 0;
        }

        #news .article-text p {
            color: #ccc;
            font-size: 14px;
        }

        .admin-buttons {
            margin-top: 20px;
        }

        .admin-buttons button {
            margin-right: 10px;
            padding: 8px 16px;
            background-color: #ffdd40;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .admin-buttons button:hover {
            background-color: darkorange;
        }
    </style>
</head>
<body>
<section id="news">
        <h2>News Admin</h2>
        <div class="news-article" id="article-container">
            <!-- Articles will be dynamically added here -->
        </div>
        <div class="admin-buttons">
            <button onclick="addArticle()">Add Article</button>
            <button onclick="deleteArticle()">Delete Last Article</button>
            <button onclick="editArticle()">Edit Last Article</button>
        </div>
    </section>

<script>
    function addArticle() {
        const container = document.getElementById('article-container');
        const article = document.createElement('div');
        article.classList.add('article');

        const articleContent = `
            <form method="post" action="submit_article.php" enctype="multipart/form-data">
                <label for="heading">Heading:</label>
                <input type="text" id="heading" name="heading" required>
                <br>
                <label for="paragraph">Paragraph:</label>
                <textarea id="paragraph" name="paragraph" rows="4" required></textarea>
                <br>
                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                <br>
                <input type="submit" value="Save">
            </form>
        `;
        article.innerHTML = articleContent;
        container.appendChild(article);
    }

    function deleteArticle() {
        const container = document.getElementById('article-container');
        const articles = container.querySelectorAll('.article');
        const lastArticle = articles[articles.length - 1];
        if (lastArticle) {
            container.removeChild(lastArticle);
        }
    }

    function editArticle() {
    const container = document.getElementById('article-container');
    const articles = container.querySelectorAll('.article');
    const lastArticle = articles[articles.length - 1];

    if (lastArticle) {
        const form = lastArticle.querySelector('form');
        if (form) {
            // Get form values
            const heading = form.querySelector('#heading').value;
            const paragraph = form.querySelector('#paragraph').value;
            const image = form.querySelector('#image').value;

            // Create article content
            const articleContent = `
                <div class="article-text">
                    <h3>${heading}</h3>
                    <p>${paragraph}</p>
                    <img src="${image}" alt="Article Image">
                </div>
            `;

            // Replace form with article content
            lastArticle.innerHTML = articleContent;
        }
    }
}

</script>
</body>
</html>
