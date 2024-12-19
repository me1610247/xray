<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use PDF;
use App\Models\Result; 
use Illuminate\Support\Facades\Auth;

class FastApiController extends Controller
{
    // Base URL of the FastAPI server
    private const FASTAPI_BASE_URL = 'http://127.0.0.1:8000';

    /**
     * Show upload form
     *
     * @return \Illuminate\View\View
     */
    public function showUploadForm()
    {
        return view('upload'); // Ensure this view exists
    }

    /**
     * Show results page
     *
     * @return \Illuminate\View\View
     */
    public function results()
    {
        return view('results'); // Ensure this view exists
    }

    /**
     * Handle image upload and analysis
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function analyzeImage(Request $request)
    {
        // Validate input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'model_type' => 'required|in:chest,bone,brain,knee',
        ]);
    
        $client = new Client();
        $imagePath = $request->file('image')->getPathname();
        $imageName = $request->file('image')->getClientOriginalName();
        $modelType = $request->input('model_type');
    
        // Store the image in the public storage and get the public path
        $storedImagePath = 'storage/images/' . $imageName;
        $request->file('image')->storeAs('public/images', $imageName);
    
        // Map model type to specialization
        $specializationMap = [
            'chest' => 'cardiology',
            'bone' => 'orthopedics',
            'brain' => 'neurology',
            'knee' => 'orthopedics',
        ];
        $specialization = $specializationMap[$modelType] ?? 'general';
    
        $url = $this->buildApiUrl($modelType); // Ensure this method exists and returns the correct API URL.
    
        try {
            $response = $client->post($url, [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($imagePath, 'r'),
                        'filename' => $imageName,
                    ],
                ],
            ]);
    
            $result = json_decode($response->getBody(), true);
            Log::info('FastAPI Response:', ['response' => $result]);
    
            $predictionData = $this->preparePredictionData($result); // Ensure this method processes and formats the response data.
    
            // Add specialization to the prediction data
            $predictionData['specialization'] = $specialization;
    
            // Save the result to the database associated with the authenticated user
            $userId = Auth::id(); // Get the currently authenticated user's ID
    
            Result::create([
                'user_id' => $userId,
                'model_type' => $modelType,
                'label' => $predictionData['label'],
                'confidence' => $predictionData['confidence'],
                'recommendation' => $predictionData['recommendation'],
                'description' => $predictionData['description'],
                'description_confidence' => $predictionData['description_confidence'],
                'specialization' => $specialization, // Store specialization
                'raw_response' => json_encode($predictionData['raw_response']),
                'image' => $storedImagePath, // Store the path of the image
            ]);
    
            return redirect()->route('results.form')->with('predictionData', $predictionData);
    
        } catch (RequestException $e) {
            // Log and handle request exceptions specifically
            $this->logRequestException($e, $url);
            return redirect()->route('upload.form')->with('error', 'An error occurred while processing the image. Please try again.');
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::critical('Unexpected error:', ['error' => $e->getMessage()]);
            return redirect()->route('upload.form')->with('error', 'Unexpected error occurred. Please try again later.');
        }
    }
    
    

    /**
     * Build the API URL for the given model type
     *
     * @param string $modelType
     * @return string
     */
    private function buildApiUrl(string $modelType): string
    {
        return self::FASTAPI_BASE_URL . "/{$modelType}/upload/";
    }

    /**
     * Prepare prediction data from the API response
     *
     * @param array $result
     * @return array
     */
    private function preparePredictionData(array $result): array
    {
        return [
            'label' => $result['label'] ?? 'Unknown',
            'confidence' => $result['confidence'] ?? 'N/A',
            'recommendation' => $result['recommendation'] ?? 'No recommendation available',
            'description' => $result['description'] ?? null, // Specific to brain or detailed models
            'description_confidence' => $result['description_confidence'] ?? null, // Specific to brain or detailed models
            'raw_response' => $result, // Pass full response for detailed debugging
        ];
    }

    /**
     * Log details of a RequestException
     *
     * @param RequestException $e
     * @param string $url
     * @return void
     */
    private function logRequestException(RequestException $e, string $url): void
    {
        Log::error('Error during API call:', [
            'url' => $url,
            'error' => $e->getMessage(),
            'request_body' => $e->getRequest()->getBody()->getContents(),
            'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No Response',
        ]);
    }
    /**
 * Generate and download the results as a PDF.
 *
 * @return \Illuminate\Http\Response
 */
/**
 * Generate and download the results as a PDF.
 *
 * @return \Illuminate\Http\Response
 */
public function downloadResults()
{
    $userId = Auth::id();

    if (!$userId) {
        return redirect()->route('upload.form')->with('error', 'User not authenticated.');
    }

    $result = Result::where('user_id', $userId)->latest()->first();

    if (!$result) {
        return redirect()->route('results.form')->with('error', 'No prediction data available.');
    }
    
    $modelType = $result->model_type; // Assuming 'model_type' is stored in the Result model

    $pdf = PDF::loadView('pdf.results', [
        'predictionData' => $result,
        'modelType' => $modelType, // Pass the model type to the view
    ]);

    return $pdf->download('analysis_results.pdf');
}


}
