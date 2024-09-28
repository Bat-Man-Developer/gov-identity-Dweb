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
    let provider, signer, userRegistry;

    if (typeof window.ethereum !== 'undefined') {
        try {
            // Request account access
            await window.ethereum.request({ method: 'eth_requestAccounts' });
            provider = new ethers.providers.Web3Provider(window.ethereum);
            signer = provider.getSigner();
            userRegistry = new ethers.Contract(UserRegistryAddress, UserRegistryABI, signer);
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
        document.querySelector('#reg-form').style.display = 'none';
    }
    
    document.getElementById('reg-form').addEventListener('submit', async (e) => {
        e.preventDefault();
    
        const firstName = document.getElementById('adminFirstName').value;
        const surname = document.getElementById('adminSurname').value;
        const email = document.getElementById('adminEmail').value;
        const password = document.getElementById('adminPassword').value;
        const rePassword = document.getElementById('adminRePassword').value;
    
        if (password !== rePassword) {
            document.getElementById('webMessageError').textContent = "Passwords do not match";
            document.getElementById('webMessageSuccess').textContent = "";
            return;
        }
    
        const passwordHash = ethers.utils.id(password);
    
        try {
            // Check if user already exists
            const exists = await userRegistry.userExists(email);
            if (exists) {
                throw new Error("User already exists");
            }
            
            // If user doesn't exist, proceed with registration
            const tx = await userRegistry.registerUser(firstName, surname, email, passwordHash);
            await tx.wait(); // Wait for the transaction to be mined
            
            console.log("Transaction result:", tx);
            
            window.location.href = "admin_login.php?success=" + encodeURIComponent("Admin Registered Successfully. Login to proceed.");
        } catch (error) {
            console.error("Registration error:", error);
            let errorMessage = "Failed To Register Admin. ";
            if (error.message.includes("User already exists")) {
                errorMessage += "This email is already registered.";
            } else if (error.message.includes("gas")) {
                errorMessage += "Transaction may have run out of gas. Please try again with a higher gas limit.";
            } else {
                errorMessage += "Try Again Or Contact Support Team: " + error.message;
            }
            document.getElementById('webMessageError').textContent = errorMessage;
            document.getElementById('webMessageSuccess').textContent = "";
        }

        clearInputs();
    });

    function clearInputs() {
        document.getElementById('adminFirstName').value = '';
        document.getElementById('adminSurname').value = '';
        document.getElementById('adminEmail').value = '';
        document.getElementById('adminPassword').value = '';
        document.getElementById('adminRePassword').value = '';
    }
});