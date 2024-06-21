<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plutchik Wheel of Emotions</title>
    <script src="https://unpkg.com/@psychological-components/plutchik/umd/plutchik.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@psychological-components/plutchik/lib/theme-core.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 50%;
            height: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="drawer"></div>
    </div>

    <script>
        let selectedEmotion = null;

        Plutchik.default({
            element: '#drawer',
            size: 300,
            levels: ['Basic'],
            onSelect: function(selected) {
                if (selectedEmotion === selected) {
                    // Deselect the currently selected emotion
                    selectedEmotion = null;
                    console.log('Deselected emotion:', selected.name);
                    alert('Deselected emotion: ' + selected.name);
                } else {
                    // Deselect the previously selected emotion, if any
                    if (selectedEmotion) {
                        console.log('Deselected emotion:', selectedEmotion.name);
                        alert('Deselected emotion: ' + selectedEmotion.name);
                    }

                    // Select the new emotion
                    selectedEmotion = selected;
                    console.log('Selected emotion:', selected.name);
                    alert('Selected emotion: ' + selected.name);
                }
            }
        });
    </script>
</body>
</html>
