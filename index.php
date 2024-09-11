<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management dApp</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.ethers.io/lib/ethers-5.0.umd.min.js"></script>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">🌓</button>
    <div class="app-container">
        <h1>User Management dApp</h1>
        <div id="landingPage">
            <h2>Welcome to our dApp!</h2>
            <p>Please register or login to continue.</p>
        </div>
        <div class="container">
            <div class="form-container">
                <h2>Register</h2>
                <input type="text" id="registerUsername" placeholder="Username" required>
                <input type="password" id="registerPassword" placeholder="Password" required>
                <button onclick="register()">Register</button>
            </div>
            <div class="form-container">
                <h2>Login</h2>
                <input type="password" id="loginPassword" placeholder="Password" required>
                <button onclick="login()">Login</button>
            </div>
        </div>
        <div id="userInfo" style="display: none;">
            <h2>Welcome, <span id="username"></span>!</h2>
            <p>You are now logged in.</p>
            <button onclick="logout()">Logout</button>
        </div>
    </div>
    <script src="script.js">
        let contract;
        let signer;

        async function init() {
            console.log('Initializing...');
            if (typeof window.ethereum !== 'undefined') {
                console.log('MetaMask is installed!');
                try {
                    console.log('Requesting account access...');
                    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                    console.log('Accounts:', accounts);
                    
                    const provider = new ethers.providers.Web3Provider(window.ethereum);
                    signer = provider.getSigner();
                    console.log('Signer:', signer);
                    
                    const contractAddress = '0x48da8e04a5b18324D151e5A3A1068E0064F118a0';
                    const abi = [
                        {
                            "anonymous": false,
                            "inputs": [
                                {
                                    "indexed": false,
                                    "internalType": "address",
                                    "name": "userAddress",
                                    "type": "address"
                                },
                                {
                                    "indexed": false,
                                    "internalType": "string",
                                    "name": "username",
                                    "type": "string"
                                }
                            ],
                            "name": "UserLoggedIn",
                            "type": "event"
                        },
                        {
                            "anonymous": false,
                            "inputs": [
                                {
                                    "indexed": false,
                                    "internalType": "address",
                                    "name": "userAddress",
                                    "type": "address"
                                },
                                {
                                    "indexed": false,
                                    "internalType": "string",
                                    "name": "username",
                                    "type": "string"
                                }
                            ],
                            "name": "UserRegistered",
                            "type": "event"
                        },
                        {
                            "inputs": [],
                            "name": "getUsername",
                            "outputs": [
                                {
                                    "internalType": "string",
                                    "name": "",
                                    "type": "string"
                                }
                            ],
                            "stateMutability": "view",
                            "type": "function"
                        },
                        {
                            "inputs": [
                                {
                                    "internalType": "string",
                                    "name": "_password",
                                    "type": "string"
                                }
                            ],
                            "name": "login",
                            "outputs": [
                                {
                                    "internalType": "bool",
                                    "name": "",
                                    "type": "bool"
                                }
                            ],
                            "stateMutability": "view",
                            "type": "function"
                        },
                        {
                            "inputs": [
                                {
                                    "internalType": "string",
                                    "name": "_username",
                                    "type": "string"
                                },
                                {
                                    "internalType": "string",
                                    "name": "_password",
                                    "type": "string"
                                }
                            ],
                            "name": "register",
                            "outputs": [],
                            "stateMutability": "nonpayable",
                            "type": "function"
                        },
                        {
                            "inputs": [
                                {
                                    "internalType": "address",
                                    "name": "",
                                    "type": "address"
                                }
                            ],
                            "name": "users",
                            "outputs": [
                                {
                                    "internalType": "string",
                                    "name": "username",
                                    "type": "string"
                                },
                                {
                                    "internalType": "bytes32",
                                    "name": "passwordHash",
                                    "type": "bytes32"
                                },
                                {
                                    "internalType": "bool",
                                    "name": "isRegistered",
                                    "type": "bool"
                                }
                            ],
                            "stateMutability": "view",
                            "type": "function"
                        }
                    ];
                    contract = new ethers.Contract(contractAddress, abi, signer);
                    console.log('Contract initialized:', contract);
                    
                    console.log('Web3 initialized successfully');
                    document.querySelector('.container').style.display = 'flex';
                } catch (error) {
                    console.error('Error initializing Web3:', error);
                    showError('Failed to connect to Web3. Error: ' + error.message);
                }
            } else {
                console.log('Web3 not detected');
                showError('Web3 not detected. Please install MetaMask to use this dApp!');
            }
        }

        function showError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            errorDiv.style.color = 'red';
            errorDiv.style.textAlign = 'center';
            errorDiv.style.marginTop = '20px';
            document.querySelector('.app-container').prepend(errorDiv);
            document.querySelector('.container').style.display = 'none';
        }

        async function register() {
            if (!contract) {
                showError('Web3 is not connected. Please refresh the page and try again.');
                return;
            }
            const username = document.getElementById('registerUsername').value;
            const password = document.getElementById('registerPassword').value;
            if (!username || !password) {
                alert('Please fill in all fields.');
                return;
            }
            try {
                const tx = await contract.register(username, password);
                await tx.wait();
                alert('Registration successful!');
                clearInputs();
            } catch (error) {
                console.error('Error:', error);
                alert('Registration failed. ' + error.message);
            }
        }

        async function login() {
            if (!contract) {
                showError('Web3 is not connected. Please refresh the page and try again.');
                return;
            }
            const password = document.getElementById('loginPassword').value;
            if (!password) {
                alert('Please enter your password.');
                return;
            }
            try {
                // Log the contract address and the user's address
                const userAddress = await signer.getAddress();
                console.log('Contract address:', contract.address);
                console.log('User address:', userAddress);

                // Try to call the users function
                try {
                    const user = await contract.users(userAddress);
                    console.log('User data:', user);
                } catch (userError) {
                    console.error('Error calling users function:', userError);
                    alert('Error retrieving user data. Please check the contract address and ABI.');
                    return;
                }

                const isLoggedIn = await contract.login(password);
                if (isLoggedIn) {
                    const username = await contract.getUsername();
                    document.getElementById('username').textContent = username;
                    document.getElementById('landingPage').style.display = 'none';
                    document.getElementById('userInfo').style.display = 'block';
                    document.querySelector('.container').style.display = 'none';
                    clearInputs();
                } else {
                    alert('Invalid password. Please try again.');
                }
            } catch (error) {
                console.error('Login error:', error);
                alert('Login failed. ' + (error.reason || error.message || 'Unknown error'));
            }
        }

        function logout() {
            document.getElementById('landingPage').style.display = 'block';
            document.getElementById('userInfo').style.display = 'none';
            document.querySelector('.container').style.display = 'flex';
        }

        function clearInputs() {
            document.getElementById('registerUsername').value = '';
            document.getElementById('registerPassword').value = '';
            document.getElementById('loginPassword').value = '';
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-theme');
            if (document.body.classList.contains('dark-theme')) {
                document.documentElement.style.setProperty('--background-color', '#333');
                document.documentElement.style.setProperty('--text-color', '#f0f0f0');
            } else {
                document.documentElement.style.setProperty('--background-color', '#f0f0f0');
                document.documentElement.style.setProperty('--text-color', '#333');
            }
        }

        init();
    </script>
</body>
</html>