package com.android.volley;

import android.os.Handler;
import java.util.concurrent.Executor;

public class ExecutorDelivery implements ResponseDelivery {
    private final Executor mResponsePoster;

    public ExecutorDelivery(final Handler handler) {
        this.mResponsePoster = new Executor() {
            public void execute(Runnable command) {
                handler.post(command);
            }
        };
    }

    public ExecutorDelivery(Executor executor) {
        this.mResponsePoster = executor;
    }

    public void postResponse(Request<?> request, Response<?> response) {
        postResponse(request, response, (Runnable) null);
    }

    public void postResponse(Request<?> request, Response<?> response, Runnable runnable) {
        request.markDelivered();
        request.addMarker("post-response");
        this.mResponsePoster.execute(new ResponseDeliveryRunnable(request, response, runnable));
    }

    public void postError(Request<?> request, VolleyError error) {
        request.addMarker("post-error");
        this.mResponsePoster.execute(new ResponseDeliveryRunnable(request, Response.error(error), (Runnable) null));
    }

    private class ResponseDeliveryRunnable implements Runnable {
        private final Request mRequest;
        private final Response mResponse;
        private final Runnable mRunnable;

        public ResponseDeliveryRunnable(Request request, Response response, Runnable runnable) {
            this.mRequest = request;
            this.mResponse = response;
            this.mRunnable = runnable;
        }

        public void run() {
            if (this.mRequest.isCanceled()) {
                this.mRequest.finish("canceled-at-delivery");
                return;
            }
            if (this.mResponse.isSuccess()) {
                this.mRequest.deliverResponse(this.mResponse.result);
            } else {
                this.mRequest.deliverError(this.mResponse.error);
            }
            if (this.mResponse.intermediate) {
                this.mRequest.addMarker("intermediate-response");
            } else {
                this.mRequest.finish("done");
            }
            Runnable runnable = this.mRunnable;
            if (runnable != null) {
                runnable.run();
            }
        }
    }
}
