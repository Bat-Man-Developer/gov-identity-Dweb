const UserRegistry = artifacts.require("UserRegistry");

module.exports = function(deployer) {
  deployer.deploy(UserRegistry);
};