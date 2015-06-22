<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jmb_technology_brokenopenapp_core');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
		$rootNode
            ->children()
            ->scalarNode('incoming_crash_url')->defaultValue('')->end()
            ->end();

		$rootNode
            ->children()
            ->booleanNode('user_registration_allowed')->defaultValue(false)->end()
            ->end();

		$rootNode
            ->children()
            ->booleanNode('new_registered_users_are_given_create_project')->defaultValue(false)->end()
            ->end();

		$rootNode
            ->children()
            ->booleanNode('proguard_retrace_jar_file_location')->defaultValue('')->end()
            ->end();

		$rootNode
            ->children()
            ->booleanNode('java_location')->defaultValue('')->end()
            ->end();

		$rootNode
			->children()
			->booleanNode('read_only')->defaultValue(true)->end()
			->end();

        return $treeBuilder;
    }
}
