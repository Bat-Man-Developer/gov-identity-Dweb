// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract UserManagement {
    struct User {
        string username;
        bytes32 passwordHash;
        bool isRegistered;
    }
    
    mapping(address => User) public users;
    
    event UserRegistered(address userAddress, string username);
    event UserLoggedIn(address userAddress, string username);
    
    function register(string memory _username, string memory _password) public {
        require(!users[msg.sender].isRegistered, "User already registered");
        
        bytes32 passwordHash = keccak256(abi.encodePacked(_password));
        users[msg.sender] = User(_username, passwordHash, true);
        
        emit UserRegistered(msg.sender, _username);
    }
    
    function login(string memory _password) public view returns (bool) {
        require(users[msg.sender].isRegistered, "User not registered");
        
        bytes32 passwordHash = keccak256(abi.encodePacked(_password));
        return users[msg.sender].passwordHash == passwordHash;
    }
    
    function getUsername() public view returns (string memory) {
        require(users[msg.sender].isRegistered, "User not registered");
        return users[msg.sender].username;
    }
}