const UserRegistryABI = [
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
    }
];

const UserRegistryAddress = "0x3df0A54274a2b0787a7f8C36C05AfdA213f45203";

window.addEventListener('load', async () => {
    if (typeof web3 !== 'undefined') {
        window.web3 = new Web3(web3.currentProvider);
    } else {
        console.log('No web3? You should consider using MetaMask!');
        window.web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:7545"));
    }

    const userRegistry = new web3.eth.Contract(UserRegistryABI, UserRegistryAddress);

    document.getElementById('reg-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const firstName = document.getElementById('adminFirstName').value;
        const surname = document.getElementById('adminSurname').value;
        const email = document.getElementById('adminEmail').value;
        const password = document.getElementById('adminPassword').value;
        const rePassword = document.getElementById('adminRePassword').value;

        if (password !== rePassword) {
            document.getElementById('webMessageError').textContent = "Passwords do not match";
            return;
        }

        const passwordHash = web3.utils.sha3(password);

        try {
            const accounts = await web3.eth.getAccounts();
            await userRegistry.methods.registerUser(firstName, surname, email, passwordHash).send({ from: accounts[0] });
            // Redirect to admin login
            window.location.href = "admin_login.php?success=" + "Admin Registered Successfully. Login to proceed.";
        } catch (error) {
            document.getElementById('webMessageError').textContent = "Failed To Register Admin. Try Again Or Contact Support Team: " + error.message;
            document.getElementById('webMessageSuccess').textContent = "";
        }
    });

    document.getElementById('login-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('adminEmail').value;
        const password = document.getElementById('adminPassword').value;

        const passwordHash = web3.utils.sha3(password);

        try {
            const accounts = await web3.eth.getAccounts();
            isLoggedIn = await userRegistry.methods.loginUser(email, passwordHash).call({ from: accounts[0] });
            
            if (isLoggedIn) {
                // Redirect to admin dashboard
                window.location.href = "admin_dashboard.php?success=" + "Admin Logged in Successfully!";
            } else {
                document.getElementById('webMessageError').textContent = "Invalid Email Or Password";
                document.getElementById('webMessageSuccess').textContent = "";
            }
        } catch (error) {
            document.getElementById('webMessageError').textContent = "Failed To Login Admin. Try Again Or Contact Support: " + error.message;
            document.getElementById('webMessageSuccess').textContent = "";
        }
    });
});