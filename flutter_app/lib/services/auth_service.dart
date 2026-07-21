import 'dart:convert';
import 'package:http/http.dart' as http;
import 'api_config.dart';
import 'session_service.dart';

class AuthService {

  static Future<Map<String, dynamic>> login(
      String correo,
      String password) async {

    final response = await http.post(
      Uri.parse(
        '${ApiConfig.baseUrl}/login.php',
      ),
      body: {
        'correo': correo,
        'password': password,
      },
    );

    final data = jsonDecode(response.body);

    if (data['success'] == true && data['usuario'] is Map<String, dynamic>) {
      SessionService.iniciar(data['usuario']);
    }

    return data;
  }

  static Future<Map<String, dynamic>> registro({
    required String nombre,
    required String tipoDocumento,
    required String numeroDocumento,
    required String correo,
    required String telefono,
    required String password,
  }) async {
    final response = await http.post(
      Uri.parse('${ApiConfig.baseUrl}/registro.php'),
      body: {
        'nombre': nombre,
        'tipo_documento': tipoDocumento,
        'numero_documento': numeroDocumento,
        'correo': correo,
        'telefono': telefono,
        'password': password,
      },
    );

    return jsonDecode(response.body);
  }
}
