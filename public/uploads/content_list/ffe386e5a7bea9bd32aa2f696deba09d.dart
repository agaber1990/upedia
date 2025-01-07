class ApiResponse<T> {
  Status status;
  T data;
  String message;

  ApiResponse.loading() : status = Status.LOADING;
  ApiResponse.completed(this.data) : status = Status.COMPLETED;
  ApiResponse.error(this.message) : status = Status.ERROR;
  ApiResponse.idle() : status = Status.IDLE;

  @override
  String toString() {
    return "Status : $status \n Message : $message \n Data : $data";
  }
}

enum Status { LOADING, LOADING_MORE, COMPLETED, ERROR, IDLE }