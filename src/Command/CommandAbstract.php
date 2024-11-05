<?php

namespace Osec\Command;

use Osec\Bootstrap\App;
use Osec\Bootstrap\OsecBaseClass;
use Osec\Http\Request\RequestParser;
use Osec\Http\Response\RenderStrategyAbstract;

/**
 * The abstract command class.
 *
 * @since      2.0
 *
 * @replaces Ai1ec_Command
 * @author     Time.ly Network Inc.
 */
abstract class CommandAbstract extends OsecBaseClass
{

    /**
     * @var RequestParser
     */
    protected $_request;

    /**
     * @var RenderStrategyAbstract
     */
    protected $_render_strategy;

    /**
     * Public constructor.
     */
    public function __construct(App $app, RequestParser $request)
    {
        parent::__construct($app);
        $this->_request = $request;
    }

    /**
     * Gets parameters from the request object.
     *
     * @return array|boolean
     */
    public function get_parameters()
    {
        $plugin = $controller = $action = null;
        $plugin = $this->_request->get_param('plugin', $plugin);
        $controller = $this->_request->get_param('controller', $controller);
        $action = $this->_request->get_param('action', $action);

        if (is_scalar($plugin)
            && OSEC_PLUGIN_NAME === (string) $plugin
            && $controller !== null
            && $action !== null
        ) {
            return [
                'controller' => $controller,
                'action'     => $action
            ];
        }

        return false;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function execute()
    {
        // Set the render strategy
        $this->set_render_strategy($this->_request);
        // get the data from the concrete implementation
        $data = $this->do_execute();
        // render it.
        $this->_render_strategy->render($data);
    }

    /**
     * Sets the render strategy.
     *
     * @param  RequestParser  $request
     */
    abstract public function set_render_strategy(RequestParser $request);

    /**
     * The abstract method concrete command must implement.
     *
     * Retrieve whats needed and returns it
     *
     * @return array
     */
    abstract public function do_execute();

    /**
     * Defines whether to stop execution of command loop or not.
     *
     * @return bool True or false.
     */
    public function stop_execution()
    {
        return false;
    }

    /**
     * Returns whether this is the command to be executed.
     *
     * I handle the logic of execution at this level, which is not usual for
     * The front controller pattern, because other extensions need to inject
     * logic into the resolver ( oAuth or ics export for instance )
     * and this seems to me to be the most logical way to do this.
     *
     * @return boolean
     */
    abstract public function is_this_to_execute();
}
