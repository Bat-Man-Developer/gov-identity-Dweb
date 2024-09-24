<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registry</title>
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.2/dist/web3.min.js"></script>
    <script>
    const UserRegistryABI = [
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": false,
                    "internalType": "string",
                    "name": "email",
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
                    "internalType": "string",
                    "name": "email",
                    "type": "string"
                }
            ],
            "name": "UserRegistered",
            "type": "event"
        },
        {
            "inputs": [
                {
                    "internalType": "string",
                    "name": "_email",
                    "type": "string"
                }
            ],
            "name": "getUserInfo",
            "outputs": [
                {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                },
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
                    "name": "_email",
                    "type": "string"
                },
                {
                    "internalType": "bytes32",
                    "name": "_passwordHash",
                    "type": "bytes32"
                }
            ],
            "name": "loginUser",
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
                    "name": "_firstName",
                    "type": "string"
                },
                {
                    "internalType": "string",
                    "name": "_surname",
                    "type": "string"
                },
                {
                    "internalType": "string",
                    "name": "_email",
                    "type": "string"
                },
                {
                    "internalType": "bytes32",
                    "name": "_passwordHash",
                    "type": "bytes32"
                }
            ],
            "name": "registerUser",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "string",
                    "name": "_email",
                    "type": "string"
                }
            ],
            "name": "userExists",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        }
    ];

    // You need to set this to your actual contract address
    const UserRegistryAddress = "YOUR_CONTRACT_ADDRESS_HERE";

    function getEmailFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('email');
    }

    async function initWeb3() {
        if (typeof window.ethereum !== 'undefined') {
            try {
                // Request account access
                await window.ethereum.request({ method: 'eth_requestAccounts' });
                window.web3 = new Web3(window.ethereum);
            } catch (error) {
                console.error("User denied account access");
                return null;
            }
        } else {
            console.log('No web3? You should consider using MetaMask!');
            window.web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:7545"));
        }
        return window.web3;
    }

    async function getUserInfo() {
        const web3 = await initWeb3();
        if (!web3) return;

        const userRegistry = new web3.eth.Contract(UserRegistryABI, UserRegistryAddress);
        
        const email = getEmailFromURL();
        if (!email) {
            console.error("Email not provided in URL");
            return;
        }

        try {
            const accounts = await web3.eth.getAccounts();

            // Retrieve and display user info
            const [firstName, surname] = await userRegistry.methods.getUserInfo(email).call({ from: accounts[0] });
            
            const adminInfoElement = document.getElementById('admin-info');
            if (adminInfoElement) {
                adminInfoElement.innerHTML = `
                    <p>First Name: ${firstName}</p>
                    <p>Surname: ${surname}</p>
                    <p>Email: ${email}</p>
                `;
            } else {
                console.error("Admin info element not found");
            }
        } catch (error) {
            console.error("Retrieve Error:", error);
            let errorMessage = "Failed To Retrieve Admin Data. ";
            errorMessage += "Try Again Or Contact Support Team: " + error.message;
            
            const errorElement = document.getElementById('webMessageError');
            if (errorElement) {
                errorElement.textContent = errorMessage;
            }
            
            const successElement = document.getElementById('webMessageSuccess');
            if (successElement) {
                successElement.textContent = "";
            }
            
            const adminInfoElement = document.getElementById('admin-info');
            if (adminInfoElement) {
                adminInfoElement.textContent = "";
            }
        }
    }

    window.addEventListener('load', getUserInfo);
    </script>
</head>
<body>
    <h1>User Registry</h1>
    <div id="admin-info"></div>
    <div id="webMessageError"></div>
    <div id="webMessageSuccess"></div>
</body>
</html>