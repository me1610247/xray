<!DOCTYPE html>
<html>
<head>
    <title>Ask Doctor</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Chat with Doctor AI</h1>
    <div>
        <textarea id="question" placeholder="Ask your medical question..."></textarea>
        <button onclick="askDoctor()">Send</button>
    </div>
    <div id="response"></div>

    <script>
        async function askDoctor() {
            const question = document.getElementById("question").value.trim();
            if (!question) {
                alert("Please enter a question.");
                return;
            }

            try {
                const response = await fetch("http://localhost:8000/api/doctor/", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ question })
                });

                if (response.ok) {
                    const data = await response.json();
                    document.getElementById("response").innerText = data.answer || "No answer available.";
                } else {
                    const errorData = await response.json();
                    alert("Error: " + (errorData.error || "Failed to get a response from the server."));
                }
            } catch (error) {
                console.error("Error asking doctor:", error);
                alert("An error occurred. Please try again.");
            }
        }
    </script>
</body>
</html>