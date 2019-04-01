<?php

require __DIR__ . "/../vendor/autoload.php";

use \React\Socket\ConnectionInterface;


class ConnectionsPool
{

    public function __construct()
    {
        $this->connections = new SplObjectStorage();
        $this->message = '';
    }


    /**
     * @param ConnectiomInterface $connection
     */
    public function add(ConnectionInterface $connection)
    {
        $this->connections->attach($connection);
        $this->logOnScreen("[New User]: {$connection->getRemoteAddress()} entered on chat..." . PHP_EOL);
        $this->sendBroadcast($connection, "[Server]: {$connection->getRemoteAddress()} entered on chat..." . PHP_EOL);

        $self = $this;
        $connection->on('data', function ($data) use ($connection, $self) {
            // ASC code to ESC (27)
            if (!empty($data) && ord($data) == 27) {
                $connection->close();
                return;
            }

            if (!empty($data) && !preg_match('/[\n]/', $data)) {
                $self->message .= filter_var($data, FILTER_SANITIZE_STRIPPED);
                return;
            }

            if (!empty($data) && preg_match('/[\n]/', $data) && !empty($self->message)) {
                $this->logOnScreen("[{$connection->getRemoteAddress()}]: {$self->message}" . PHP_EOL);
                $this->sendBroadcast($connection, "[{$connection->getRemoteAddress()}]: {$self->message}" . PHP_EOL);
                $self->message = '';
            }
        });

        $connection->on('close', function () use ($connection) {
            $this->connections->detach($connection);
            $this->logOnScreen("[User Out]: {$connection->getRemoteAddress()} was disconnected..." . PHP_EOL);
            $this->sendBroadcast($connection, "[Server]: {$connection->getRemoteAddress()} was disconnected!" . PHP_EOL);
        });
    }

    public function getConnectionName(ConnectionInterface $conn)
    {
        return $this->connections->offSetGet($conn);
    }

    public function setConnectionName(ConnectionInterface $conn, $name)
    {
        $this->connections->offsetSet($conn, $name);
    }

    public function logOnScreen($message = '')
    {
        if (!empty($message)) {
            echo $message;
        }
    }

    public function sendBroadcast(ConnectionInterface $origin = null, $message = '')
    {
        if (!is_null($origin) && !empty($message)) {
            foreach ($this->connections as $conn) {
                if ($conn !== $origin) {
                    $conn->write($message);
                }
            }
        }
    }
}
