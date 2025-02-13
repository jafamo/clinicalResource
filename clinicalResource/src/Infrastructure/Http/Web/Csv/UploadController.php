<?php

namespace App\Infrastructure\Http\Web\Csv;

use App\Application\UseCase\ProcessFileUseCase;
use App\Infrastructure\Service\Csv\FileProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;

#[IsGranted('ROLE_ADMIN', statusCode: 423)]
class UploadController extends AbstractController
{

    private FileProcessor $fileProcessor;
    private ProcessFileUseCase $useCase;

    public function __construct(FileProcessor $fileProcessor, ProcessFileUseCase $useCase)
    {
        $this->fileProcessor = $fileProcessor;
        $this->useCase = $useCase;
    }

    #[IsGranted('ROLE_ADMIN', message: 'You are not allowed to access the Upload')]
    #[Route('/upload-csv', name: 'app_csv_load', methods: ['GET', 'POST'])]
    public function upload(Request $request): Response
    {
        $result = ['validRows' => [], 'errors' => []];

        if ($request->isMethod('POST')) {
            $file = $request->files->get('file');

            if (!$file) {
                return new Response('No file uploaded', Response::HTTP_BAD_REQUEST);
            }

            if ($file && $file->getClientOriginalExtension() === 'xlsx') {
                try {
                    // Leer datos del archivo Excel con encabezados
                    $rows = $this->fileProcessor->readExcelWithHeaders($file->getPathname());

                    // Procesar datos a través del caso de uso
                    $processingResult = $this->useCase->process($rows);

                    $result['validRows'] = $processingResult['valid'] ?? [];
                    $result['errors'] = $processingResult['errors'] ?? [];

                    $this->addFlash('success', 'File imported: ');

                    return $this->render('web/csv/result.html.twig', [
                        'validRows' => $result['validRows'],
                        'errors' => $result['errors'],
                    ]);

                } catch (FileException $e) {
                    $this->addFlash('error', 'Error al subir el archivo: ' . $e->getMessage());
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Error al procesar el archivo: ' . $e->getMessage());
                }
            } else {
                $this->addFlash('error', 'Por favor, sube un archivo Excel válido (.xlsx).');
            }
        }

        return $this->render('web/csv/upload.html.twig', [
            'validRows' => $result['validRows'],
            'errors' => $result['errors'],
        ]);
    }
}