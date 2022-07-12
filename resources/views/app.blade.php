@extends('layouts.app')

@section('content')
    <script>
        __info__ = {
            user: @js($user),
            token: `{{ $token }}`,
            rpc: `{{ route('rpc.endpoint', absolute: false) }}`,
        };

        __routes__ = {
            replaceUrl(url, data) {
                const regex = new RegExp(':(' + Object.keys(data).join('|') + ')', 'g');

                return url.replace(regex, (m, $1) => data[$1] || m);
            },
            reportDownload({ id }) {
                return this.replaceUrl(`{{{ route('report.download', ['report' => ':id']) }}}`, { id })
            }
        }
    </script>
    <div id="pwa">
        <router-view></router-view>
    </div>
    <script>
        // if ('serviceWorker' in navigator ) {

        //     window.addEventListener('load', async () => {
        //         try {
        //             const registration = await navigator.serviceWorker.register('/service-worker.js')

        //             console.log('ServiceWorker registration successful with scope: ', registration.scope);
        //         } catch (error) {
        //             console.error('ServiceWorker registration failed: ', err);
        //         }
        //     });
        // }
</script>
@endsection
