import 'dart:convert';
import 'package:http/http.dart' as http;
import 'api_config.dart';
import 'session_service.dart';

class ReservaService {
  static Future<Map<String, dynamic>> crear({
    required String nombre,
    required String telefono,
    required String fecha,
    required String hora,
    required int personas,
    required String observaciones,
  }) async {
    final usuarioId = SessionService.usuarioId;

    if (usuarioId == null) {
      return {
        'success': false,
        'mensaje': 'Debes iniciar sesion para reservar',
      };
    }

    final response = await http.post(
      Uri.parse('${ApiConfig.baseUrl}/reservas.php'),
      body: {
        'usuario_id': usuarioId.toString(),
        'nombre': nombre,
        'telefono': telefono,
        'fecha': fecha,
        'hora': hora,
        'personas': personas.toString(),
        'observaciones': observaciones,
      },
    );

    return jsonDecode(response.body);
  }
}
