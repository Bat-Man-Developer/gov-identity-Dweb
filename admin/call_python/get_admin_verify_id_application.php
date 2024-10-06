<?php
class Model
{
    private $pythonExePath = "c:/Users/user/AppData/Local/Programs/Python/Python312/python.exe";
    private $scriptPaths = "c:/Xampp/htdocs/gov-identity-Dweb/admin/python/admin_verify_id_application.py";
    private $command = "-c"; 

    private function executeCommand($scriptPath)
    {
        $escapedPythonScript = escapeshellarg($scriptPath);
        $fullCommand = $this->pythonExePath . " " . $escapedPythonScript . " " . $this->command;
        return shell_exec($fullCommand);
    }

    public function getModel()
    {
        $scriptPath = $this->scriptPaths;
        return $this->executeCommand($scriptPath);
    }
}

$model = new Model();
echo $model->getModel();