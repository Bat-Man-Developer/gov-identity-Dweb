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
        "inputs": [],
        "name": "getBlockNumber",
        "outputs": [
            {
                "internalType": "uint256",
                "name": "",
                "type": "uint256"
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

const UserRegistryAddress = "0x4d33F8f18e27A2cF4D8F2B8BB5B40809d4e2fE70";

window.addEventListener('load', async () => {
    if (typeof window.ethereum !== 'undefined') {
        try {
            // Request account access
            await window.ethereum.request({ method: 'eth_requestAccounts' });
            window.provider = new ethers.providers.Web3Provider(window.ethereum);
            window.signer = provider.getSigner();
            console.log('Ethers initialized successfully');
        } catch (error) {
            console.error('Error initializing Ethers:', error);
            showError('Failed to connect to Ethereum. Please make sure MetaMask is installed, connected, and you have approved this site.');
        }
    } else {
        console.log('Ethereum provider not detected');
        showError('Ethereum provider not detected. Please install MetaMask to use this dApp!');
    }

    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        errorDiv.style.color = 'red';
        errorDiv.style.textAlign = 'center';
        errorDiv.style.marginTop = '20px';
        document.querySelector('#reg-login-form').prepend(errorDiv);
        document.querySelector('#login-form').style.display = 'none';
    }

    const userRegistry = new ethers.Contract(UserRegistryAddress, UserRegistryABI, signer);
    
    document.getElementById('login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
    
        const email = document.getElementById('adminEmail').value;
        const password = document.getElementById('adminPassword').value;

        clearInputs();
    
        const passwordHash = ethers.utils.id(password);
    
        try {
            // Get admin account
            await signer.getAddress();
            
            // Check if user exists
            const userExists = await userRegistry.userExists(email);
            
            if (!userExists) {
                document.getElementById('webMessageError').textContent = "User with this email does not exist";
                document.getElementById('webMessageSuccess').textContent = "";
                return;
            }
            
            // If user exists, attempt to login
            const isLoggedIn = await userRegistry.loginUser(email, passwordHash);
            
            if (isLoggedIn) {    
                // Get block number as Admin ID
                const adminID = await userRegistry.getBlockNumber();    
                
                window.location.href = "server/get_admin_login.php?success=" + encodeURIComponent("Admin Logged in Successfully!") + "&adminID=" + adminID + "&adminEmail=" + email;
            } else {
                document.getElementById('webMessageError').textContent = "Invalid Email Or Password";
                document.getElementById('webMessageSuccess').textContent = "";
            }
        } catch (error) {
            console.error("Login error:", error);
            let errorMessage = "Failed To Login Admin. ";
            if (error.message.includes("gas")) {
                errorMessage += "Transaction may have run out of gas. Please try again with a higher gas limit.";
            } else {
                errorMessage += "Try Again Or Contact Support Team: " + error.message;
            }
            document.getElementById('webMessageError').textContent = errorMessage;
            document.getElementById('webMessageSuccess').textContent = "";
        }

        function clearInputs() {
            document.getElementById('adminEmail').value = '';
            document.getElementById('adminPassword').value = '';
        }
    });
});