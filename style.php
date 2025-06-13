body {
    background: linear-gradient(to right, #dbe9f4, #f0f4f8);
    font-family: 'Segoe UI', sans-serif;
    padding: 20px;
}

.container {
    max-width: 700px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
}

form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

input[type="text"], select {
    padding: 10px;
    border: 2px solid #1e90ff;
    border-radius: 10px;
    flex: 1;
}

button {
    background: linear-gradient(to right, #1e90ff, #4682b4);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
}

.card {
    background: #f8f9fa;
    border-left: 5px solid #1e90ff;
    padding: 15px;
    margin-top: 15px;
    border-radius: 8px;
}

.pagination a {
    padding: 8px 12px;
    margin: 5px;
    background: #1e90ff;
    color: white;
    border-radius: 6px;
    text-decoration: none;
}

.pagination a.active {
    background: #4682b4;
}
