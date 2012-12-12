<?php
/**
 * BaconLiquibase
 *
 * @link      http://github.com/Bacon/BaconLiquibase For the canonical source repository
 * @copyright 2011-2012 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconLiquibase\Controller;

use XMLWriter;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Aggregate controller.
 */
class AggregateController extends AbstractActionController
{
    /**
     * Module manager.
     *
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * Create a new aggregate controller.
     *
     * @param ModuleManager $moduleManager
     */
    public function __construct(ModuleManager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    /**
     * Aggregate all changesets.
     *
     * @return string
     */
    public function aggregateAction()
    {
        $outputFilename = $this->params('output');
        $modules        = $this->moduleManager->getLoadedModules();

        $writer = new XMLWriter();
        $writer->openURI($outputFilename);
        $writer->setIndent(true);
        $writer->setIndentString('    ');
        $writer->startDocument('1.0', 'utf-8');
        
        $writer->startElement('databaseChangeLog');
        $writer->writeAttribute('xmlns', 'http://www.liquibase.org/xml/ns/dbchangelog');
        $writer->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $writer->writeAttribute('xmlns:ext', 'http://www.liquibase.org/xml/ns/dbchangelog-ext');
        $writer->writeAttribute(
            'xsi:schemaLocation',
            'http://www.liquibase.org/xml/ns/dbchangelog'
            . ' http://www.liquibase.org/xml/ns/dbchangelog/dbchangelog-2.0.xsd'
            . ' http://www.liquibase.org/xml/ns/dbchangelog-ext'
            . ' http://www.liquibase.org/xml/ns/dbchangelog/dbchangelog-ext.xsd'
        );

        foreach ($modules as $module) {
            if (!method_exists($module, 'getLiquibasePath')) {
                continue;
            }

            $writer->startElement('include');
            $writer->writeAttribute('file', $module->getLiquibasePath());
            $writer->endElement();
        }

        $writer->endElement();
        $writer->endDocument();

        return "Aggregated change set generated.\n";
    }
}
