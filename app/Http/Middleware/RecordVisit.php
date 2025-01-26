<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visit;
use GeoIp2\Database\Reader;
use MaxMind\Db\Reader\InvalidDatabaseException;

class RecordVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $ip = $request->ip();
            $url = $request->fullUrl();
            $method = $request->method();
            $userAgent = $request->userAgent();
            $country = 'Unknown';
            
            // Skip localhost IPs
            if ($ip === '127.0.0.1' || $ip === '::1') {
                $country = 'Local';
            } else {
                // Initialize the GeoIP2 reader
                $reader = new Reader(storage_path('app/GeoLite2-Country.mmdb'));
                
                try {
                    // Try to get the country from the IP
                    $record = $reader->country($ip);
                    $country = $record->country->isoCode;
                    
                    if (empty($country)) {
                        \Log::warning("Empty country code returned for IP: {$ip}");
                        $country = 'Unknown';
                    }
                    
                } catch (InvalidDatabaseException $e) {
                    \Log::error("GeoIP Database Error: {$e->getMessage()}");
                    $country = 'DB Error';
                } catch (\GeoIp2\Exception\AddressNotFoundException $e) {
                    \Log::warning("IP not found in database: {$ip}");
                    $country = 'Not Found';
                } catch (\Exception $e) {
                    \Log::warning("Could not determine country for IP: {$ip}. Error: " . $e->getMessage());
                    $country = 'Error';
                }
            }

            // Create the visit record
            Visit::create([
                'ip_address' => $ip,
                'url' => $url,
                'method' => $method,
                'user_agent' => $userAgent,
                'country' => $country
            ]);

        } catch (\Exception $e) {
            // Log the error but don't stop the request
            \Log::error("Error recording visit: " . $e->getMessage());
        }

        return $next($request);
    }
}
