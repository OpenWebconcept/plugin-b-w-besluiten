<?php

namespace OWC\Besluiten\Support;

use Closure;
use OWC\Besluiten\Foundation\Plugin;
use WP_Post;

abstract class CreatesFields
{
	/**
	 * Instance of the Plugin.
	 */
	protected Plugin $plugin;

	/** @var Closure */
	protected $condition = null;

	/**
	 * @param Plugin $plugin
	 */
	public function __construct(Plugin $plugin)
	{
		$this->plugin = $plugin;
	}

	/**
	 * The default condition is true, can be overriden.
	 *
	 * @return callable
	 */
	protected function condition(): callable
	{
		return function () {
			return \__return_true();
		};
	}

	/**
	 * Run the current condition.
	 *
	 * @return null|Closure
	 */
	public function executeCondition(): ?Closure
	{
		if ($this->condition() instanceof Closure) {
			return $this->condition();
		}

		if (\is_callable($this->condition())) {
			return $this->condition();
		}

		return null;
	}

	/**
	 * Create an additional field on an array.
	 *
	 * @param WP_Post $post
	 *
	 * @return mixed
	 */
	abstract public function create(WP_Post $post);
}
