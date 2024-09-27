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

const UserRegistryAddress = "0x0E01863877C33a6AA27C03C007EB4ba59820959a";

window.addEventListener('load', async () => {
    if (typeof window.ethereum !== 'undefined') {
		try {
			// Request account access
			await window.ethereum.request({ method: 'eth_requestAccounts' });
			window.web3 = new Web3(window.ethereum);
			console.log('Web3 initialized successfully');
		} catch (error) {
			console.error('Error initializing Web3:', error);
			showError('Failed to connect to Web3. Please make sure MetaMask is installed, connected, and you have approved this site.');
		}
	} else {
		console.log('Web3 not detected');
		showError('Web3 not detected. Please install MetaMask to use this dApp!');
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

    const userRegistry = new web3.eth.Contract(UserRegistryABI, UserRegistryAddress);
    
    document.getElementById('login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
    
        const email = document.getElementById('adminEmail').value;
        const password = document.getElementById('adminPassword').value;

		clearInputs();
    
        const passwordHash = web3.utils.sha3(password);
    
        try {
            const accounts = await web3.eth.getAccounts();
            
            // Check if user exists
            const userExists = await userRegistry.methods.userExists(email).call();
            
            if (!userExists) {
                document.getElementById('webMessageError').textContent = "User with this email does not exist";
                document.getElementById('webMessageSuccess').textContent = "";
                return;
            }
            
            // If user exists, attempt to login
			const isLoggedIn = await userRegistry.methods.loginUser(email, passwordHash).call({ from: accounts[0] });
            
            if (isLoggedIn) {	
				// Get block number as Admin ID
				const admin_id = await userRegistry.methods.getBlockNumber(email).call();	
                window.location.href = "server/get_admin_login.php?success=" + encodeURIComponent("Admin Logged in Successfully!") + "&adminID=" + admin_id + "&adminEmail=" + email;
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