const UserRegistry = artifacts.require("UserRegistry");

module.exports = async function(deployer, network, accounts) {
  try {
    await deployer.deploy(UserRegistry);
    const userRegistryInstance = await UserRegistry.deployed();
    console.log(`UserRegistry deployed at: ${userRegistryInstance.address}`);
  } catch (error) {
    console.error("Error in migration:", error);
  }
};