<?php

namespace InfyOm\Generator\Commands\Publish;

class PublishTemplateCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'infyom.publish:templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes api generator templates.';

    private $templatesDir;

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->templatesDir = config(
            'infyom.laravel_generator.path.templates_dir',
            base_path('resources/infyom/')
        );

        if ($this->publishGeneratorTemplates('laravel-generator')) {
            $this->publishScaffoldTemplates();
        }

        $swagger = config('infyom.laravel_generator.add_on.swagger', false);
        if ($swagger) {
            $this->publishGeneratorTemplates('swagger-generator');
        }
    }

    /**
     * Publishes templates.
     */
    public function publishGeneratorTemplates($templateType)
    {
        $templatesPath = __DIR__.'/../../../../'.$templateType.'/templates';

        return $this->publishDirectory($templatesPath, $this->templatesDir.$templateType.'/templates', $templateType.'/templates');
    }

    /**
     * Publishes templates.
     */
    public function publishScaffoldTemplates()
    {
        $templateType = config('infyom.laravel_generator.templates', 'adminlte-templates');

        $templatesPath = base_path('vendor/infyomlabs/'.$templateType.'/templates/scaffold');

        return $this->publishDirectory($templatesPath, $this->templatesDir.'/scaffold', 'infyom-generator-templates/scaffold', true);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }
}
