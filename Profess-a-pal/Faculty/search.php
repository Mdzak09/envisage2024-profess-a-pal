
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plagiarism Detection Tool</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 80px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 36px;
            margin-bottom: 30px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        textarea {
            width: 98%;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            resize: vertical;
            font-size: 16px;
        }

        input[type="file"] {
            width: 98%;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            padding: 12px 30px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-top: 30px;
        }

        ul li {
            margin-bottom: 20px;
        }

        ul li a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
            transition: color 0.3s;
        }

        ul li a:hover {
            color: #0056b3;
        }

        p.no-results {
            text-align: center;
            color: #888;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🕵️‍♀️ Plagiarism Detection Tool 🕵️‍♂️</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <textarea name="text" placeholder="Paste your text here..." rows="8"><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''; ?></textarea>
            <input type="file" name="file" accept=".txt,.doc,.docx,.pdf">
            <button type="submit">Search</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['text']) && !empty(trim($_POST['text']))) {

                $inputText = $_POST["text"];
            } elseif (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {

                $inputText = file_get_contents($_FILES['file']['tmp_name']);
            }


            $apiKey = 'AIzaSyCh6BkXPcykpadr25bDQLmB5-NxC8ei60c';
            $cx = '777ebd2e8bd8b4edc';


            $encodedText = urlencode($inputText);
            $url = "https://www.googleapis.com/customsearch/v1?q=$encodedText&cx=$cx&key=$apiKey";
            
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            
            if (isset($data['items']) && count($data['items']) > 0) {
                echo "<ul>";
                foreach ($data['items'] as $item) {
                    echo "<li><a href='" . $item['link'] . "' target='_blank'>" . $item['title'] . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p class='no-results'>No results found. 🤔 Try again with different text!</p>";
            }
        }
        ?>
    </div>
</body>
</html>
