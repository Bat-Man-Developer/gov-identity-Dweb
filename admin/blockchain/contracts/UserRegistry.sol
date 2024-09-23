pragma solidity ^0.8.0;

contract UserRegistry {
    struct User {
        string firstName;
        string surname;
        string email;
        bytes32 passwordHash;
    }

    mapping(address => User) public users;

    event UserRegistered(address userAddress, string email);

    function registerUser(string memory _firstName, string memory _surname, string memory _email, bytes32 _passwordHash) public {
        require(bytes(users[msg.sender].email).length == 0, "User already registered");
        
        users[msg.sender] = User(_firstName, _surname, _email, _passwordHash);
        emit UserRegistered(msg.sender, _email);
    }

    function loginUser(string memory _email, bytes32 _passwordHash) public view returns (bool) {
        User memory user = users[msg.sender];
        return (keccak256(abi.encodePacked(user.email)) == keccak256(abi.encodePacked(_email)) &&
                user.passwordHash == _passwordHash);
    }

    function getUser(address _userAddress) public view returns (string memory, string memory, string memory) {
        User memory user = users[_userAddress];
        return (user.firstName, user.surname, user.email);
    }
}